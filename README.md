# Laravel+React with PayPal Integration

This is a full-stack web application built with **Laravel** as the backend and **React** components in the frontend. The application allows users to create tasks with associated prices, process payments via PayPal, and manage task statuses based on payment completion.

## Features

### Frontend (React)
1. **Task List Display**:

2. **Add Task with Payment**:


## Setup Instructions

### Prerequisites
- **PHP** (>= 7.4)
- **Composer** (for PHP dependencies)
- **Node.js** and **npm** (for frontend development)
- **MySQL** or any other database supported by Laravel
- **PayPal Developer Account** (for sandbox credentials)

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Shashy95/first_react_app.git
   cd first_react_app
   ```

2. **Install PHP dependencies**:
   - Run Composer to install Laravel dependencies:
     ```bash
     composer install
     ```

3. **Configure the environment**:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Generate the application key:
     ```bash
     php artisan key:generate
     ```

5. **Install frontend dependencies**:
  install npm dependencies:
     ```bash
     npm install
     ```

6. **Compile React components**:
   - Compile the React components for production:
     ```bash
     npm run dev
     ```
   - Alternatively, for development with hot-reloading:
     ```bash
     npm run watch
     ```

7. **Run the Laravel server**:
   - Start the Laravel development server:
     ```bash
     php artisan serve
     ```

8. **Access the application**:
   - Open your browser and navigate to `http://localhost:8000`.

### PayPal Integration
- Update the PayPal client ID

## Usage
1. **User Authentication**:
   - Register or log in to access the task management features.
   
2. **Task Management**:
   - View the list of tasks with their prices.
   - Add a new task with a price and proceed to PayPal for payment.
   - Once the payment is successful, the task status will be updated.

3. **Payment History**:
   - Users can view their payment history in the application.

## Project Structure

### Laravel Backend
- `app/Http/Controllers/`: Contains the controllers for handling API requests.
- `app/Models/`: Contains the Eloquent models for database interactions.
- `database/migrations/`: Contains the database migration files.
- `routes/api.php`: Defines the API routes for the application.
- `config/`: Contains configuration files for PayPal and other services.

### React Frontend
- `resources/js/`: Contains the React components.
  - `components/`: React components for the task list, task creation form, and payment integration.
  - `views/`: Main views for the application.
  - `App.js`: Main React application file.
- `resources/sass/`: Contains SCSS files for styling (if used).
- `webpack.mix.js`: Laravel Mix configuration for compiling assets.

## Dependencies

### Laravel Backend
- Laravel Framework
- MySQL (for database)

### React Frontend
- React
- Axios (for API requests)
- Tailwind (for styling)
- PayPal SDK (for payment integration)

## Contributing
If you'd like to contribute, please fork the repository and create a pull request. You can also open an issue for any bugs or feature requests.



This `README.md` should give a clear overview of your project and guide anyone who wants to set it up or contribute to it.