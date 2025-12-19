// worker-ui.js - Complete file
const WorkerUI = {
    // Show add worker modal
    showAddModal: function() {
        // Initialize form if modal doesn't exist
        if (!$('#addWorkerModal').length) {
            this.initAddModal();
        }
        
        // Reset form and show modal
        this.resetAddForm();
        const modal = new bootstrap.Modal(document.getElementById('addWorkerModal'));
        modal.show();
    },
    
    // Initialize modal functionality
    initAddModal: function() {
        const self = this;
        
        // Form submission
        $('#addWorkerForm').on('submit', function(e) {
            e.preventDefault();
            self.saveWorker();
        });
        
        // CNIC formatting
        $('input[name="cnic"]').on('input', function(e) {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length > 13) value = value.substr(0, 13);
            
            if (value.length > 5) {
                value = value.substr(0, 5) + '-' + value.substr(5);
            }
            if (value.length > 13) {
                value = value.substr(0, 13) + '-' + value.substr(13);
            }
            
            $(this).val(value);
        });
        
        // Generate password
        $('#generatePassword').on('click', function() {
            const password = self.generateRandomPassword();
            $('input[name="password"]').val(password);
        });
        
        // Toggle password visibility
        $('#togglePassword').on('click', function() {
            const input = $('input[name="password"]');
            const type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
        
        // Real-time validation
        $('input, select').on('blur', function() {
            self.validateField($(this));
        });
    },
    
    // Generate random password
    generateRandomPassword: function() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#$%';
        let password = '';
        for (let i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return password;
    },
    
    // Validate field
    validateField: function($field) {
        const name = $field.attr('name');
        const value = $field.val().trim();
        
        if ($field.prop('required') && !value) {
            $field.addClass('is-invalid');
            return false;
        }
        
        // Specific validations
        if (name === 'cnic' && value) {
            const cnicRegex = /^\d{5}-\d{7}-\d{1}$/;
            if (!cnicRegex.test(value)) {
                $field.addClass('is-invalid');
                return false;
            }
        }
        
        if (name === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                $field.addClass('is-invalid');
                return false;
            }
        }
        
        if (name === 'password' && value.length < 6) {
            $field.addClass('is-invalid');
            return false;
        }
        
        $field.removeClass('is-invalid');
        return true;
    },
    
    // Reset form
    resetAddForm: function() {
        $('#addWorkerForm')[0].reset();
        $('input[name="salary"]').val('15000');
        $('select[name="status"]').val('active');
        $('.is-invalid').removeClass('is-invalid');
        $('input[name="password"]').attr('type', 'password');
        $('#togglePassword i').removeClass('fa-eye-slash').addClass('fa-eye');
    },
    
    // Save worker to API
    saveWorker: function() {
        const self = this;
        const form = $('#addWorkerForm')[0];
        
        // Validate all fields
        let isValid = true;
        $(form).find('input[required], select[required]').each(function() {
            if (!self.validateField($(this))) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            alert('Please fill all required fields correctly.');
            return;
        }
        
        // Get form data
        const formData = {
            name: $('input[name="name"]').val().trim(),
            cnic: $('input[name="cnic"]').val().trim(),
            password: $('input[name="password"]').val(),
            email: $('input[name="email"]').val().trim(),
            category: $('select[name="category"]').val(),
            salary: parseInt($('input[name="salary"]').val()),
            phone: $('input[name="phone"]').val().trim(),
            status: $('select[name="status"]').val(),
            notes: $('textarea[name="notes"]').val().trim(),
            hired_date: new Date().toISOString().split('T')[0] // Today's date
        };
        
        // Show loading
        const saveBtn = $('#saveWorkerBtn');
        saveBtn.prop('disabled', true);
        saveBtn.find('.spinner-border').removeClass('d-none');
        
        // Call API to save worker
        WorkerAPI.addWorker(formData)
            .then(function(response) {
                // Hide modal
                $('#addWorkerModal').modal('hide');
                
                // Show success message
                alert('Worker added successfully!');
                
                // Refresh worker list
                WorkerAPI.loadWorkers()
                    .then(workers => {
                        WorkerTable.render(workers);
                        WorkerFilters.init(workers);
                    });
            })
            .catch(function(error) {
                console.error('Error adding worker:', error);
                alert('Failed to add worker: ' + (error.message || 'Unknown error'));
            })
            .finally(function() {
                // Reset button
                saveBtn.prop('disabled', false);
                saveBtn.find('.spinner-border').addClass('d-none');
            });
    },
    
    // Show edit modal (if needed)
    showEditModal: function(workerId) {
        // Fetch worker details and show edit modal
        WorkerAPI.getWorker(workerId)
            .then(worker => {
                // Similar to add modal but pre-filled
                console.log('Edit worker:', worker);
                // You can implement edit functionality here
            })
            .catch(error => {
                console.error('Error fetching worker:', error);
                alert('Failed to load worker details');
            });
    }
};