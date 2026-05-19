<script>
(function () {
    function initUploadZone(zone) {
        var input = zone.querySelector('input[type="file"]');
        var filenameEl = zone.querySelector('[data-filename]');
        var fieldName = zone.getAttribute('data-upload-zone');
        var previewEl = document.querySelector('[data-preview="' + fieldName + '"]');
        if (!input) {
            return;
        }

        function showFile(file) {
            if (!file) {
                return;
            }
            if (filenameEl) {
                filenameEl.textContent = file.name;
            }
            zone.classList.add('has-file');
            if (previewEl && file.type && file.type.indexOf('image/') === 0) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    previewEl.innerHTML = '<div class="case-upload-preview__label">New upload preview</div><img src="' + e.target.result + '" alt="Preview">';
                    previewEl.hidden = false;
                };
                reader.readAsDataURL(file);
            }
        }

        input.addEventListener('change', function () {
            if (input.files && input.files[0]) {
                showFile(input.files[0]);
            }
        });

        ['dragenter', 'dragover'].forEach(function (ev) {
            zone.addEventListener(ev, function (e) {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.add('is-dragover');
            });
        });
        ['dragleave', 'drop'].forEach(function (ev) {
            zone.addEventListener(ev, function (e) {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.remove('is-dragover');
            });
        });
        zone.addEventListener('drop', function (e) {
            var files = e.dataTransfer && e.dataTransfer.files;
            if (files && files.length) {
                input.files = files;
                showFile(files[0]);
            }
        });
    }

    document.querySelectorAll('.case-upload-zone').forEach(initUploadZone);
})();
</script>
