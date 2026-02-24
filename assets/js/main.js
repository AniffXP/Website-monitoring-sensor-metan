/* ============================================
   MAIN JAVASCRIPT
   Sensor Monitoring System
   ============================================ */

// ============================================
// Dropdown & Navigation Functions
// ============================================

/**
 * Toggle user dropdown menu
 */
function toggleDropdown() {
    const dropdown = document.getElementById('user-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
}

/**
 * Toggle mobile navigation menu
 */
function toggleMobileMenu() {
    const nav = document.getElementById('main-nav');
    const toggle = document.querySelector('.mobile-menu-toggle');

    if (nav) {
        nav.classList.toggle('show');
    }

    if (toggle) {
        toggle.classList.toggle('active');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function (event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('user-dropdown');

    if (userMenu && dropdown && !userMenu.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});

// Close mobile menu when clicking outside
document.addEventListener('click', function (event) {
    const nav = document.getElementById('main-nav');
    const toggle = document.querySelector('.mobile-menu-toggle');

    if (nav && toggle && !nav.contains(event.target) && !toggle.contains(event.target)) {
        nav.classList.remove('show');
        toggle.classList.remove('active');
    }
});

// ============================================
// CRUD Functions
// ============================================

/**
 * Navigate to add data page
 * @param {string} table - Table name (tbdatasensor or tbjenissensor)
 */
function addData(table) {
    if (table === 'tbdatasensor') {
        window.location.href = getBasePath() + 'pages/add_data.php';
    } else if (table === 'tbjenissensor') {
        window.location.href = getBasePath() + 'pages/add_data_sensor.php';
    }
}

/**
 * Navigate to edit data page
 * @param {string} table - Table name
 * @param {string} id - Record identifier
 */
function editData(table, id) {
    if (table === 'tbdatasensor') {
        window.location.href = getBasePath() + 'pages/edit_data.php?waktu=' + encodeURIComponent(id);
    } else if (table === 'tbjenissensor') {
        window.location.href = getBasePath() + 'pages/edit_data_sensor.php?id=' + encodeURIComponent(id);
    }
}

/**
 * Delete data with confirmation
 * @param {string} table - Table name
 * @param {string} id - Record identifier
 */
function deleteData(table, id) {
    // Create custom confirmation modal
    showConfirmModal(
        'Konfirmasi Hapus',
        'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
        function () {
            if (table === 'tbdatasensor') {
                window.location.href = getBasePath() + 'pages/delete_data.php?waktu=' + encodeURIComponent(id);
            } else if (table === 'tbjenissensor') {
                window.location.href = getBasePath() + 'pages/delete_data_sensor.php?id=' + encodeURIComponent(id);
            }
        }
    );
}

/**
 * Get base path for links
 */
function getBasePath() {
    const path = window.location.pathname;
    if (path.includes('/pages/')) {
        return '../';
    }
    return '';
}

// ============================================
// Confirmation Modal
// ============================================

/**
 * Show confirmation modal
 */
function showConfirmModal(title, message, onConfirm) {
    // Create modal if doesn't exist
    let modal = document.getElementById('confirm-modal');

    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'confirm-modal';
        modal.innerHTML = `
            <div class="modal-overlay" onclick="hideConfirmModal()"></div>
            <div class="modal-content">
                <h3 class="modal-title"></h3>
                <p class="modal-message"></p>
                <div class="modal-actions">
                    <button class="btn btn-secondary" onclick="hideConfirmModal()">Batal</button>
                    <button class="btn btn-danger" id="modal-confirm-btn">Hapus</button>
                </div>
            </div>
        `;

        // Add modal styles
        const style = document.createElement('style');
        style.textContent = `
            #confirm-modal {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                visibility: hidden;
                transition: all 0.2s ease;
            }
            #confirm-modal.show {
                opacity: 1;
                visibility: visible;
            }
            .modal-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
            }
            .modal-content {
                position: relative;
                background: white;
                padding: 24px;
                border-radius: 16px;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
                max-width: 400px;
                width: 90%;
                transform: scale(0.9);
                transition: transform 0.2s ease;
            }
            #confirm-modal.show .modal-content {
                transform: scale(1);
            }
            .modal-title {
                font-size: 18px;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 12px;
            }
            .modal-message {
                color: #6b7280;
                font-size: 14px;
                line-height: 1.5;
                margin-bottom: 24px;
            }
            .modal-actions {
                display: flex;
                gap: 12px;
                justify-content: flex-end;
            }
        `;
        document.head.appendChild(style);
        document.body.appendChild(modal);
    }

    // Set content
    modal.querySelector('.modal-title').textContent = title;
    modal.querySelector('.modal-message').textContent = message;

    // Set confirm action
    const confirmBtn = document.getElementById('modal-confirm-btn');
    confirmBtn.onclick = function () {
        hideConfirmModal();
        if (onConfirm) onConfirm();
    };

    // Show modal
    modal.classList.add('show');
}

/**
 * Hide confirmation modal
 */
function hideConfirmModal() {
    const modal = document.getElementById('confirm-modal');
    if (modal) {
        modal.classList.remove('show');
    }
}

// ============================================
// Map Initialization (for pages with maps)
// ============================================

/**
 * Initialize Leaflet map
 */
function initMap(containerId, locations) {
    // Check if map container exists
    const container = document.getElementById(containerId);
    if (!container) return null;

    // Check if locations exist
    if (!locations || locations.length === 0) {
        // Default center (Palembang)
        var map = L.map(containerId).setView([-2.991639, 104.763482], 13);
    } else {
        // Center on first location
        var map = L.map(containerId).setView([locations[0].lat, locations[0].lng], 13);
    }

    // Light theme tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add markers for each location
    if (locations && locations.length > 0) {
        locations.forEach(function (location) {
            // Create custom marker icon
            const markerHtml = `
                <div style="
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    width: 30px;
                    height: 30px;
                    border-radius: 50% 50% 50% 0;
                    transform: rotate(-45deg);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
                ">
                    <span style="
                        transform: rotate(45deg);
                        color: white;
                        font-size: 12px;
                        font-weight: bold;
                    ">📍</span>
                </div>
            `;

            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: markerHtml,
                iconSize: [30, 42],
                iconAnchor: [15, 42],
                popupAnchor: [0, -42]
            });

            L.marker([location.lat, location.lng], { icon: customIcon })
                .addTo(map)
                .bindPopup(`
                    <div style="font-family: 'Inter', sans-serif; min-width: 150px;">
                        <strong style="font-size: 14px;">${location.nama}</strong>
                        <br>
                        <span style="color: #6b7280; font-size: 12px;">
                            📍 ${location.lat.toFixed(6)}, ${location.lng.toFixed(6)}
                        </span>
                    </div>
                `);
        });
    }

    // Add click event to show coordinates
    map.on('click', function (e) {
        const coord = e.latlng;
        L.popup()
            .setLatLng(coord)
            .setContent(`
                <div style="font-family: 'Inter', sans-serif;">
                    <strong>Koordinat</strong><br>
                    Lat: ${coord.lat.toFixed(6)}<br>
                    Lng: ${coord.lng.toFixed(6)}
                </div>
            `)
            .openOn(map);
    });

    return map;
}

// ============================================
// Utility Functions
// ============================================

/**
 * Format date to Indonesian locale
 */
function formatDate(dateString) {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

/**
 * Format number with Indonesian locale
 */
function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;

    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 24px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideInUp 0.3s ease;
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOutDown 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ============================================
// Initialize on DOM Ready
// ============================================

document.addEventListener('DOMContentLoaded', function () {
    // Add animation class to cards
    const cards = document.querySelectorAll('.card, .stat-card, .table-container');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate-fadeIn');
    });

    // Initialize map if locations variable exists
    if (typeof locations !== 'undefined' && document.getElementById('map')) {
        initMap('map', locations);
    }
});

// Add keyboard support for user icon
document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' || event.key === ' ') {
        if (document.activeElement.classList.contains('user-icon')) {
            toggleDropdown();
        }
    }

    // Close dropdown on Escape
    if (event.key === 'Escape') {
        hideConfirmModal();
        const dropdown = document.getElementById('user-dropdown');
        if (dropdown) dropdown.classList.remove('show');
    }
});
