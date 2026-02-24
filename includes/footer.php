    </main>
    
    <footer class="footer" style="
        background: var(--white);
        padding: var(--space-lg) var(--space-xl);
        margin-top: var(--space-2xl);
        text-align: center;
        box-shadow: var(--shadow-sm);
    ">
        <p style="color: var(--text-secondary); font-size: var(--font-size-sm);">
            &copy; <?php echo date('Y'); ?> PT Pupuk Sriwidjaja Palembang - Sistem Monitoring Sensor Metan
        </p>
    </footer>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Main JavaScript -->
    <script src="assets/js/main.js"></script>
    
    <?php if (isset($additionalJS)): ?>
    <script><?php echo $additionalJS; ?></script>
    <?php endif; ?>
</body>
</html>
