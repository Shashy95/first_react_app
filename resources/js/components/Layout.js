// resources/js/components/Layout.js
import React from 'react';
import { Link } from 'react-router-dom';

const Layout = ({ children, isAuthenticated, onLogout }) => {
  return (
    <div className="min-h-screen flex flex-col">
      <header className="bg-gray-800 text-white">
        <nav className="container mx-auto p-4 flex justify-between">
          <div className="flex space-x-4">
            {isAuthenticated ? (
              <>
                <Link to="/" className="hover:underline">Home</Link>
                <button onClick={onLogout} className="hover:underline">
                  Logout
                </button>
              </>
            ) : (
              <>
                <Link to="/login" className="hover:underline">Login</Link>
                <Link to="/register" className="hover:underline">Register</Link>
              </>
            )}
          </div>
        </nav>
      </header>
      <main className="flex-grow container mx-auto p-4">
        {children}
      </main>
    </div>
  );
};

export default Layout;