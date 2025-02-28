// src/App.js
import React from "react";
import { BrowserRouter as Router, Route, Routes, Navigate } from "react-router-dom";
import Layout from "./Layout";
import TaskList from "./pages/Task";
import Register from "./pages/Register";
import Login from "./pages/Login";
import PaymentHistory from "./pages/PaymentHistory";
import { AuthProvider, useAuth } from "./context/AuthProvider";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const App = () => {
  return (
    <AuthProvider>
      <Router>
        <Main />
        <ToastContainer />
      </Router>
    </AuthProvider>
  );
};

const Main = () => {
  const { isAuthenticated, logout } = useAuth(); // Get the authentication state and logout function

  return (
    <Layout isAuthenticated={isAuthenticated} onLogout={logout}>
      <Routes>
        {/* If authenticated, show TaskList and redirect to it */}
        {isAuthenticated ? (
          <>
            <Route path="/" element={<TaskList />} />         
            <Route path="/login" element={<Navigate to="/" replace />} />
            <Route path="/register" element={<Navigate to="/" replace />} />
            <Route path="/payments" element={<PaymentHistory />} />
          </>
        ) : (
          // If not authenticated, show Login and Register
          <>
            <Route path="/" element={<Navigate to="/login" replace />} />
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />
          </>
        )}
      </Routes>
    </Layout>
  );
};

export default App;