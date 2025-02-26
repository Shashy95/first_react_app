// src/components/TaskList.js
import React, { useEffect, useState } from "react";
import axios from "axios";
import axiosInstance from "../context/axiosInstance";
import { useAuth } from "../context/AuthProvider";
import TaskModal from "./TaskModal";

const TaskList = () => {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [error, setError] = useState(null); // State for error handling
  const { isAuthenticated, logout } = useAuth(); // Get user from AuthProvider

  // Fetch tasks when the component mounts
  useEffect(() => {
    if (isAuthenticated) {
      fetchTasks();
    }
  }, [isAuthenticated]); // Dependency array includes isAuthenticated

  const fetchTasks = async () => {
    try {
      const response = await axiosInstance.get("/tasks");
      setTasks(response.data);
    } catch (error) {
      console.error("Error fetching tasks:", error);
      setError("Failed to fetch tasks. Please try again later."); // Set error message
    } finally {
      setLoading(false);
    }
  };

  if (!isAuthenticated) {
    return <p className="text-center text-red-500">Please log in to view tasks.</p>;
  }

  return (
    <div className="container mx-auto p-4">
      <h2 className="text-2xl font-bold mb-4">Task List</h2>
      <button 
        className="mb-4 bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200"
        onClick={() => setIsModalOpen(true)}>
        Add Task
      </button>
      {loading ? (
        <p className="text-center">Loading tasks...</p>
      ) : error ? (
        <p className="text-center text-red-500">{error}</p> // Display error message
      ) : (
        <div className="overflow-x-auto">
          <table className="min-w-full bg-white border border-gray-300">
            <thead>
              <tr className="bg-gray-200 text-gray-700">
                <th className="py-2 px-4 border-b">Task Title</th>
                <th className="py-2 px-4 border-b">Description</th>
                <th className="py-2 px-4 border-b">Price (USD)</th>
                <th className="py-2 px-4 border-b">Status</th>
              </tr>
            </thead>
            <tbody>
              {tasks.length > 0 ? (
                tasks.map((task) => (
                  <tr key={task.id} className="hover:bg-gray-100">
                    <td className="py-2 px-4 border-b">{task.title}</td>
                    <td className="py-2 px-4 border-b">{task.description}</td>
                    <td className="py-2 px-4 border-b">${parseFloat(task.price).toFixed(2)}</td>
                    <td className="py-2 px-4 border-b">{task.status}</td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="4" className="py-2 px-4 text-center">
                    No tasks available
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      )}
      <TaskModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} refreshTasks={fetchTasks} />
    </div>
  );
};

export default TaskList;