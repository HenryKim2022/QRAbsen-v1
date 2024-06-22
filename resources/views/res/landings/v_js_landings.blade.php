<!-- BEGIN: Vendor JS-->
<script src="{{ asset('public/vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
{{-- <script src="{{ asset('public/vuexy/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('public/vuexy/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('public/vuexy/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('public/vuexy/app-assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
{{-- <script src="{{ asset('public/vuexy/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script> --}}
<script src="{{ asset('public/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>

<script>
    $(document).ready(function() {
        // Check if there are elements with the class 'select2' present
        if ($('.select2').length > 0) {
            // Initialize Select2
            $('.select2').select2();
        }
    });
</script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hoverImages = document.querySelectorAll('.hover-image');
        const imagePopup = document.getElementById('image-popup');
        const popupImage = imagePopup.querySelector('img');
        const closeBtn = imagePopup.querySelector('.close-btn');

        hoverImages.forEach(function(image) {
            image.addEventListener('click', function() {
                const largeImageSrc = this.getAttribute('src');
                popupImage.src = largeImageSrc;
                imagePopup.style.display = 'block';
                centerPopup();
            });
        });

        closeBtn.addEventListener('click', function() {
            imagePopup.style.display = 'none';
        });

        var modalViewImagesPreview = document.getElementById('swiperImagesContainerView');
        if (modalViewImagesPreview) {
            document.getElementById('swiperImagesContainerView').addEventListener('click', function(event) {
                // var modalImagesPreview = document.getElementById('swiperImagesContainerView');
                // var modalViewImage = new bootstrap.Modal(document.getElementById('modalViewLogoPopUp'));
                var modalViewZoomImageContent = document.getElementById('modalViewZoomImageContent');

                var clickedImage = event.target.closest('img');
                if (clickedImage) {
                    const largeImageSrc = clickedImage.getAttribute('src');
                    // var clickedImageUrl = clickedImage.src;
                    popupImage.src = largeImageSrc;
                    imagePopup.style.display = 'block';
                    centerPopup();
                }
            });
        }


        // Center the popup when the window is resized
        window.addEventListener('resize', function() {
            if (imagePopup.style.display === 'block') {
                centerPopup();
            }
        });

        // Function to center the popup
        function centerPopup() {
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            const popupWidth = imagePopup.offsetWidth;
            const popupHeight = imagePopup.offsetHeight;

            const topPosition = (windowHeight - popupHeight) / 2;
            const leftPosition = (windowWidth - popupWidth) / 2;

            imagePopup.style.top = topPosition + 'px';
            imagePopup.style.left = leftPosition + 'px';
        }

        var hover_images = document.querySelectorAll('.hover-image');
        if (hover_images.length > 0) {
            hover_images.forEach(function(hover_img) {
                hover_img.setAttribute('data-bs-toggle', 'tooltip');
                hover_img.setAttribute('data-bs-placement', 'top');
                hover_img.setAttribute('title', 'Click to Enlarge!');
            });
        }
    });
</script>


<script>
    function openModal(modalId) {
        var modal = document.querySelector(modalId);
        $(document).ready(function() {
            var bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        });
    }
</script>
