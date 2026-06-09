<script src="{{ asset('admin_assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('admin_assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin_assets/js/app.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('js/admin-crud.js') }}"></script>

<script>
    function togglePassword(id) {
        const passwordInput = document.getElementById(id);
        const eyeIcon = document.getElementById(`eye-${id}`);
        const isVisible = passwordInput.type === 'text';
        passwordInput.type = isVisible ? 'password' : 'text';
        eyeIcon.className = isVisible ? 'bi bi-eye-slash' : 'bi bi-eye';
    }

    function confirmDelete(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    window.previewImage = function (input, targetId = 'imagePreview') {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const target = document.getElementById(targetId);
                if (target) target.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        const darkModeButton = document.getElementById('darkModeButton');
        const moonIcon = document.getElementById('moonIcon');
        const userName = document.querySelector('.user-name');
        let darkMode = localStorage.getItem('darkMode') === 'enabled';
        updateTheme(darkMode);

        darkModeButton?.addEventListener('click', function () {
            darkMode = !darkMode;
            localStorage.setItem('darkMode', darkMode ? 'enabled' : 'disabled');
            updateTheme(darkMode);
        });

        function updateTheme(isDark) {
            moonIcon.src = isDark
                ? "{{ asset('default/moon_dark.png') }}"
                : "{{ asset('default/moon_light.png') }}";
            document.documentElement.classList.toggle('dark-theme', isDark);
            if (userName) {
                userName.textContent = isDark ? 'Dark' : 'Light';
            }
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('.editor').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function (files) {
                    uploadImage(files[0], $(this));
                },
                onMediaDelete: function (target) {
                    deleteImage($(target).attr('src'), $(this));
                }
            }
        });

        function uploadImage(file, editor) {
            let formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.ckeditor.upload') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (url) {
                    editor.summernote('insertImage', url);
                },
                error: function () {
                    toastr.error('Error uploading image');
                }
            });
        }

        function deleteImage(imageSrc, editor) {
            const filename = imageSrc.substring(imageSrc.lastIndexOf('/') + 1);
            $.ajax({
                url: "{{ route('admin.ckeditor.delete') }}",
                type: 'POST',
                data: { filename: filename, _token: '{{ csrf_token() }}' },
                success: function (response) {
                    const editable = editor.summernote('getLayoutInfo').editable[0];
                    $(`img[src="${imageSrc}"]`, editable).remove();
                },
                error: function () {
                    toastr.error('Error deleting image');
                }
            });
        }
    });
</script>