import React, { createContext, useContext, useState, useEffect } from 'react';
import axiosInstance from '../context/axiosInstance'; // Adjust the import based on your project structure

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser ] = useState(null); // State to hold user information

    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            setIsAuthenticated(true);
            fetchUser (); // Fetch user information if token exists
        }
    }, []);

    const fetchUser  = async () => {
        try {
            const response = await axiosInstance.get('/user'); // Adjust the endpoint as needed
            setUser (response.data); // Assuming the response contains user data
        } catch (error) {
            console.error('Failed to fetch user:', error);
            setIsAuthenticated(false); // Optionally handle authentication failure
        }
    };

    const login = (token, userData) => {
        localStorage.setItem('token', token);
        setIsAuthenticated(true);
        setUser (userData); // Set user data on login
    };

    const logout = () => {
        localStorage.removeItem('token');
        setIsAuthenticated(false);
        setUser (null); // Clear user data on logout
    };

    return (
        <AuthContext.Provider value={{ isAuthenticated, user, login, logout }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => {
    return useContext(AuthContext);
};