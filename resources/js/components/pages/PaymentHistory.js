import React, { useEffect, useState } from "react";
import axiosInstance from "../context/axiosInstance";
import { useAuth } from "../context/AuthProvider";
import DataTable from "react-data-table-component";

const PaymentHistory = () => {
  const { user } = useAuth(); // Get the user from context
  const [payments, setPayments] = useState([]);
  const [filterText, setFilterText] = useState(""); // State for search input


  useEffect(() => {
    const fetchPayments = async () => {
      try {
        const response = await axiosInstance.get(`/payments?user_id=${user.id}`); // Adjust the endpoint as needed
        setPayments(response.data);
      } catch (error) {
        console.error("Error fetching payments:", error);
      }
    };

    if (user) {
      fetchPayments();
    }
  }, [user]);

  const columns = [
    {
      name: "Payment ID",
      selector: (row) => row.payment_id,
      sortable: true,
    },
    {
      name: "Amount",
      selector: (row) => `${row.amount} ${row.currency}`,
      sortable: true,
    },
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
  const filteredPayments = payments.filter((payment) =>
    Object.values(payment)
      .join(" ") // Convert object values to a string
      .toLowerCase()
      .includes(filterText.toLowerCase())
  );

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-semibold mb-4">Payment History</h1>

      {/* Flex container for search input and table */}
      <div className="flex flex-wrap justify-between items-center mb-4 space-y-4 sm:space-y-0 sm:flex-row">
    {/* Add Task Button */}
    <div className="sm:w-auto w-full">
     
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

      <div className="overflow-x-auto bg-white shadow-md rounded-lg">
        <DataTable
          columns={columns}
          data={filteredPayments} // Use filtered data
          pagination
          highlightOnHover
          responsive
          striped
          subHeader={true}
          persistTableHead
        />
      </div>
    </div>
  );
};

export default PaymentHistory;
