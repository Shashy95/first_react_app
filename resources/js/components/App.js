// resources/js/components/App.js
import React, { useEffect, useState } from 'react';
import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom';
import Layout from './Layout'; // Assuming you have a Layout component
import TaskList from './pages/Tasklist'; // Your TaskList component
import Register from './pages/Register'; // Your Register component
import Login from './pages/Login'; // Your Login component
import axios from 'axios';

const App = () => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const checkAuth = async () => {
      try {
        const response = await axios.get(`/api/user`, {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
          withCredentials: true,
        });
        if (response.status === 200) {
          setIsAuthenticated(true);
        }
      } catch (error) {
        setIsAuthenticated(false);
      } finally {
        setLoading(false);
      }
    };

    checkAuth();
  }, []);

  const handleLogout = async () => {
    try {
      await axios.post(`api/logout`, {}, { withCredentials: true });
      setIsAuthenticated(false);
    } catch (error) {
      console.error('Logout failed', error);
    }
  };

  if (loading) {
    return <div>Loading...</div>; // Show a loading state while checking authentication
  }

  return (
    <Router>
      <Layout isAuthenticated={isAuthenticated} onLogout={handleLogout}>
        <Routes>
          <Route path="/" element={isAuthenticated ? <TaskList /> : <Navigate to="/login" />} />
          <Route path="/register" element={<Register />} />
          <Route path="/login" element={<Login setIsAuthenticated={setIsAuthenticated} />} />
        </Routes>
      </Layout>
    </Router>
  );
};

export default App;