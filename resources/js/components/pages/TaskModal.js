// src/components/TaskModal.js
import React, { useState, useContext } from "react";
import axiosInstance from "../context/axiosInstance";
import { PayPalScriptProvider, PayPalButtons } from "@paypal/react-paypal-js";
import { useAuth } from "../context/AuthProvider"; // Import your Auth context
import { toast } from "react-toastify"; // Import the toast function
import "react-toastify/dist/ReactToastify.css";

const TaskModal = ({ isOpen, onClose, refreshTasks }) => {
  const { user } = useAuth(); // Get the user from context
  const [taskTitle, setTaskTitle] = useState("");
  const [taskDescription, setTaskDescription] = useState("");
  const [taskPrice, setTaskPrice] = useState("");
  const [error, setError] = useState("");

  if (!isOpen) return null;

  const handleTaskCreation = async () => {
    try {
      const taskResponse = await axiosInstance.post("/tasks", {
        title: taskTitle,
        description: taskDescription,
        price: taskPrice,
      });
      return taskResponse.data.id; // Return the task ID
    } catch (err) {
      setError("Failed to create task. Please try again.");
      toast.error("Task creation failed. Please try again.");
      console.error("Error:", err);
      throw err; // Rethrow the error for handling in the PayPal button
    }
  };

  const savePayment = async (paymentId, amount, currency, userId, taskId) => {
    try {
      await axiosInstance.post("/payments", {
        payment_id: paymentId,
        amount: amount,
        currency: currency,
        status: "completed", // Set the status to completed
        user_id: userId, // Use the actual user ID
        task_id: taskId,
      });
      toast.success("Payment successful! Task created!");
    } catch (err) {
      toast.error("Failed to save payment. Please try again.");
      console.error("Error saving payment:", err);
    }
  };

  return (
    <div className="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
      <div className="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 className="text-xl font-bold mb-4">Add Task</h2>
        {error && <p className="text-red-500 mb-4">{error}</p>}
        <form onSubmit={(e) => e.preventDefault()}>
          <input
            type="text"
            placeholder="Task Title"
            value={taskTitle}
            onChange={(e) => setTaskTitle(e.target.value)}
            required
            className="w-full p-2 border border-gray-300 rounded mb-4"
          />
          <textarea
            placeholder="Task Description"
            value={taskDescription}
            onChange={(e) => setTaskDescription(e.target.value)}
            required
            className="w-full p-2 border border-gray-300 rounded mb-4"
            rows="4"
          />
          <input
            type="number"
            placeholder="Price"
            value={taskPrice}
            onChange={(e) => setTaskPrice(e.target.value)}
            required
            className="w-full p-2 border border-gray-300 rounded mb-4"
          />
          <PayPalScriptProvider options={{ "client-id": "ART6SVykZQrbVnfQAU6pNdER5ERR22gToQ1eLonXKsOG3KPs3T4IJsBygCz7t1gwWzQPVVPzGNHnaBMO" }}>
            <PayPalButtons
              createOrder={async (data, actions) => {
                const taskId = await handleTaskCreation(); // Create the task and get the ID
                return actions.order.create({
                  purchase_units: [{
                    amount: {
                      value: taskPrice,
                    },
                    custom_id: taskId, // Pass the task ID as a custom ID
                  }],
                });
              }}
              onApprove={async (data, actions) => {
                await actions.order.capture().then(async (details) => {
                  const taskId = details.purchase_units[0].custom_id;
                  if (!taskId) {
                    throw new Error("Task ID is not available.");
                  }

                  // Save payment details to the database
                  await savePayment(
                    details.id, // PayPal payment ID
                    taskPrice, // Amount
                    "USD", // Currency
                    user.id, // Use the actual user ID from context
                    taskId // Task ID
                  );

                  // Update task status after successful payment
                  await axiosInstance.put(`/tasks/${taskId}`, { status: "completed" });
                  refreshTasks(); // Refresh the task list
                  setTaskTitle("");
                  setTaskDescription("");
                  setTaskPrice("");
                  onClose();
                });
              }}
              onError={(err) => {
                setError("Payment failed. Please try again.");
                console.error("PayPal Error:", err);
              }}
            />
          </PayPalScriptProvider>
          <div className="flex justify-end space-x-2 mt-4">
            <button
              type="button"
              onClick={onClose}
              className="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default TaskModal;