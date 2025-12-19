

/**
 * Worker Filters Module - Handles search and filtering
 */

const WorkerFilters = {
    workers: [],
    filteredWorkers: [],

    // Initialize filters with worker data
    init: function(workers) {
        this.workers = workers;
        this.filteredWorkers = [...workers];
        
        this.setupEventListeners();
        this.applyFilters();
    },

    // Setup event listeners for filters
    setupEventListeners: function() {
        const $searchInput = $('#search-input');
        const $categoryFilter = $('#category-filter');
        const $statusFilter = $('#status-filter');
        const $clearFilters = $('#clear-filters');
        
        // Search input with debounce
        let searchTimeout;
        $searchInput.off('input').on('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.applyFilters();
            }, 300);
        });
        
        // Category filter
        $categoryFilter.off('change').on('change', () => {
            this.applyFilters();
        });
        
        // Status filter
        $statusFilter.off('change').on('change', () => {
            this.applyFilters();
        });
        
        // Clear filters
        $clearFilters.off('click').on('click', () => {
            this.clearFilters();
        });
    },

    // Apply all filters
    applyFilters: function() {
        const searchTerm = $('#search-input').val().toLowerCase();
        const category = $('#category-filter').val();
        const status = $('#status-filter').val();
        
        this.filteredWorkers = this.workers.filter(worker => {
            // Search filter
            if (searchTerm) {
                const matchesSearch = 
                    (worker.name && worker.name.toLowerCase().includes(searchTerm)) ||
                    (worker.cnic && worker.cnic.includes(searchTerm)) ||
                    (worker.email && worker.email.toLowerCase().includes(searchTerm)) ||
                    (worker.phone && worker.phone.includes(searchTerm)) ||
                    (worker.notes && worker.notes.toLowerCase().includes(searchTerm));
                
                if (!matchesSearch) return false;
            }
            
            // Category filter
            if (category && worker.category !== category) {
                return false;
            }
            
            // Status filter
            if (status && worker.status !== status) {
                return false;
            }
            
            return true;
        });
        
        // Update table
        WorkerTable.render(this.filteredWorkers);
    },

    // Clear all filters
    clearFilters: function() {
        $('#search-input').val('');
        $('#category-filter').val('');
        $('#status-filter').val('');
        
        this.filteredWorkers = [...this.workers];
        WorkerTable.render(this.filteredWorkers);
    },

    // Get worker by ID
    getWorkerById: function(workerId) {
        return this.workers.find(worker => worker.worker_id == workerId);
    },

    // Get all workers
    getAllWorkers: function() {
        return this.workers;
    }
};

// Make filters globally available
window.WorkerFilters = WorkerFilters;
