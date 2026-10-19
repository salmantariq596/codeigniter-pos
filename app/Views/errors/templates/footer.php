<script>
        // Add error reporting functionality if needed
        document.addEventListener('DOMContentLoaded', function() {
            console.error('Error occurred:', <?= json_encode($errorDetails) ?>);
        });
    </script>
</body>
</html>