

/**
 * Worker Table Module - Handles table rendering
 */

const WorkerTable = {
    // Render workers table
    render: function(workers) {
        const tableBody = document.getElementById('workers-table-body');
        const loadingState = document.getElementById('loading-state');
        const emptyState = document.getElementById('empty-state');
        const workerCount = document.getElementById('worker-count');
        
        // Hide loading state
        if (loadingState) {
            loadingState.style.display = 'none';
        }
        
        // Update worker count
        if (workerCount) {
            workerCount.textContent = `${workers.length} workers found`;
        }
        
        // Handle empty state
        if (!workers || workers.length === 0) {
            tableBody.innerHTML = '';
            if (emptyState) {
                emptyState.style.display = 'block';
            }
            return;
        }
        
        // Hide empty state
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        // Render table rows
        const rows = workers.map((worker, index) => this.createRow(worker, index)).join('');
        tableBody.innerHTML = rows;
    },

    // Create a single table row
    createRow: function(worker, index) {
        const statusClass = worker.status === 'Active' ? 'badge bg-success' : 'badge bg-secondary';
        const salary = parseFloat(worker.salary_per) || 0;
        const passwordHash = worker.password_hash || '';
        
        return `
            <tr>
                <td>${index + 1}</td>
                <td><span class="badge bg-primary">${worker.worker_id || 'N/A'}</span></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="worker-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 36px; height: 36px; font-weight: bold;">
                            ${worker.name ? worker.name.charAt(0).toUpperCase() : '?'}
                        </div>
                        <div>
                            <strong>${this.escapeHtml(worker.name || 'N/A')}</strong>
                            <br>
                            <small class="text-muted">${this.escapeHtml(worker.email || '')}</small>
                        </div>
                    </div>
                </td>
                <td><code class="cnic-cell">${this.escapeHtml(worker.cnic || 'N/A')}</code></td>
                <td class="password-cell">
                    <span>••••••••</span>
                    <button class="btn btn-sm btn-outline-secondary ms-1" 
                            onclick="WorkerUI.togglePassword(this, '${this.escapeHtml(passwordHash)}')">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
                <td>
                    <a href="mailto:${this.escapeHtml(worker.email || '')}" class="text-decoration-none">
                        ${this.escapeHtml(worker.email || 'N/A')}
                    </a>
                </td>
                <td><span class="badge bg-info">${this.escapeHtml(worker.category || 'N/A')}</span></td>
                <td>Rs. ${salary.toFixed(2)}</td>
                <td><span class="${statusClass}">${worker.status || 'N/A'}</span></td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" 
                                onclick="WorkerUI.showEditModal(${worker.worker_id})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-info" 
                                onclick="WorkerUI.viewDetails(${worker.worker_id})" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-danger" 
                                onclick="WorkerUI.showDeleteModal(${worker.worker_id})" title="Deactivate">
                            <i class="bi bi-person-x"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    },

    // Escape HTML special characters
    escapeHtml: function(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
    }
};

// Make globally available
window.WorkerTable = WorkerTable;
