import React, { useState } from "react";
import { useNavigate,Link } from "react-router-dom";
import { useAuth } from "../context/AuthProvider"; // Import AuthProvider
import axios from "axios";

const Register = () => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();
  const { login } = useAuth(); // Use login function from AuthProvider (optional)

  const handleRegister = async (e) => {
    e.preventDefault();
    try {
      // Call the registration API endpoint
      const response = await axios.post('/api/register', {
        name,
        email,
        password,
      });

      const { token, user } = response.data; 
      login(token, user);// Log the user in after registration
      navigate("/"); // Redirect to home page on success
      
    } catch (err) {
      if (err.response?.data?.errors) {
        const errorMessages = Object.values(err.response.data.errors).flat().join(", ");
        setError(errorMessages);
      } else {
        setError("Registration failed. Please try again.");
      }
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 className="text-2xl font-bold mb-6 text-center">Register</h2>
        {error && <p className="text-red-500 mb-4">{error}</p>}
        <form onSubmit={handleRegister}>
          <div className="mb-4">
            <input
              type="text"
              placeholder="Name"
              value={name}
              onChange={(e) => setName(e.target.value)}
              required
              className="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-300"
            />
          </div>
          <div className="mb-4">
            <input
              type="email"
              placeholder="Email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
              className="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-300"
            />
          </div>
          <div className="mb-4">
            <input
              type="password"
              placeholder="Password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              className="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-300"
            />
          </div>
          <button
            type="submit"
            className="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200"
          >
            Register
          </button>
        </form>
        <p className="mt-4 text-center">
          Already have an account?{" "}
          <Link to="/login" className="text-blue-500 hover:underline">
            Login Here
          </Link>
        </p>
      </div>
    </div>
  );
};

export default Register;