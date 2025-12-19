

/**
 * API Module - Handles all API communication
 */

const WorkerAPI = {
    baseURL: '../include/',

    // Load all workers
    async loadWorkers() {
        try {
            const response = await fetch(`${this.baseURL}get_workers.php`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            return data;
        } catch (error) {
            console.error('Failed to load workers:', error);
            throw error;
        }
    },

    // Add a new worker
    async addWorker(formData) {
        try {
            const response = await fetch(`${this.baseURL}add_worker.php`, {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('Failed to add worker:', error);
            throw error;
        }
    },

    // Update an existing worker
    async updateWorker(formData) {
        try {
            const response = await fetch(`${this.baseURL}update_worker.php`, {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('Failed to update worker:', error);
            throw error;
        }
    },

    // Delete/deactivate a worker
    async deleteWorker(workerId) {
        try {
            const response = await fetch(`${this.baseURL}delete_worker.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `worker_id=${workerId}`
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('Failed to delete worker:', error);
            throw error;
        }
    },

    // Validate worker data
    validateWorker(data) {
        const errors = [];
        
        // Validate required fields
        const required = ['name', 'cnic', 'phone', 'email', 'category', 'salary_per'];
        required.forEach(field => {
            if (!data[field] || data[field].toString().trim() === '') {
                errors.push(`${field.replace('_', ' ')} is required`);
            }
        });
        
        // Validate CNIC format
        if (data.cnic && !/^\d{5}-\d{7}-\d{1}$/.test(data.cnic)) {
            errors.push('CNIC must be in format: XXXXX-XXXXXXX-X');
        }
        
        // Validate phone
        if (data.phone && !/^\d{11}$/.test(data.phone)) {
            errors.push('Phone must be exactly 11 digits');
        }
        
        // Validate email
        if (data.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
            errors.push('Valid email is required');
        }
        
        // Validate password for new workers
        if (data.password && data.password.length < 8) {
            errors.push('Password must be at least 8 characters');
        }
        
        // Validate salary
        if (data.salary_per && parseFloat(data.salary_per) <= 0) {
            errors.push('Salary must be greater than 0');
        }
        
        return errors;
    }
};

// Make API globally available
window.WorkerAPI = WorkerAPI;
