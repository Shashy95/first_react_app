// src/components/TaskList.js
import React, { useEffect, useState } from "react";
import axiosInstance from "../context/axiosInstance";
import { useAuth } from "../context/AuthProvider";
import TaskModal from "./TaskModal";
import DataTable from "react-data-table-component";

const TaskList = () => {
  const [tasks, setTasks] = useState([]);
  const [filterText, setFilterText] = useState(""); // State for search input
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

  const columns = [
    { name: "Task Title", selector: row => row.title, sortable: true },
    { name: "Description", selector: row => row.description, sortable: true },
    { name: "Price (USD)", selector: row => `$${parseFloat(row.price).toFixed(2)}`, sortable: true },
    {
      name: "Status",
      selector: (row) => row.status,
      sortable: true,
      cell: (row) => (
        <span
          className={`inline-block px-2 py-1 text-xs font-semibold rounded-md ${
            row.status === "completed" ? " text-green-800" : " text-red-800"
          }`}
        >
          {row.status.charAt(0).toUpperCase() + row.status.slice(1)}
        </span>
      ),
    },
    {
      name: "Date",
      selector: (row) => new Date(row.created_at).toLocaleDateString(),
      sortable: true,
    },
  ];

    // Filter function that searches across all columns
    const filteredTasks = tasks.filter((task) =>
      Object.values(task)
        .join(" ") // Convert object values to a string
        .toLowerCase()
        .includes(filterText.toLowerCase())
    );


  return (
    <div className="container mx-auto p-4">
  <h1 className="text-2xl font-semibold mb-4">Task List</h1>

  {/* Flex container for search input and button */}
  <div className="flex flex-wrap justify-between items-center mb-4 space-y-4 sm:space-y-0 sm:flex-row">
    {/* Add Task Button */}
    <div className="sm:w-auto w-full">
      <button 
        className="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200 w-full sm:w-auto"
        onClick={() => setIsModalOpen(true)}>
        Add Task
      </button>
    </div>

    {/* Search Input */}
    <div className="sm:w-64 w-full">
      <input
        type="text"
        placeholder="Search..."
        value={filterText}
        onChange={(e) => setFilterText(e.target.value)}
        className="p-2 border rounded-md shadow-sm w-full"
      />
    </div>
  </div>

  {/* Task Table */}
  <div className="overflow-x-auto bg-white shadow-md rounded-lg">
    <DataTable
      columns={columns}
      data={filteredTasks} // Use filtered data
      pagination
      highlightOnHover
      responsive
      striped
      subHeader={true}
      persistTableHead
    />
  </div>

  {/* Task Modal */}
  <TaskModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} refreshTasks={fetchTasks} />
</div>

  );
};

export default TaskList;