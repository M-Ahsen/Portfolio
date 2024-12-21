const setupGallery = (gallerySelector, prevButtonId, nextButtonId, imgWidth) => {
    const gallery = document.querySelector(gallerySelector);
    const prevButton = document.getElementById(prevButtonId);
    const nextButton = document.getElementById(nextButtonId);
    let currentPosition = 0;

    const updateButtons = () => {
        const galleryWidth = gallery.scrollWidth;
        const containerWidth = gallery.parentElement.offsetWidth;

        // Disable/enable buttons based on position
        prevButton.disabled = currentPosition === 0;
        nextButton.disabled = currentPosition + containerWidth >= galleryWidth;
    };

    nextButton.addEventListener('click', () => {
        const galleryWidth = gallery.scrollWidth;
        const containerWidth = gallery.parentElement.offsetWidth;

        if (currentPosition + containerWidth < galleryWidth) {
            currentPosition += imgWidth;
            gallery.style.transform = `translateX(-${currentPosition}px)`;
        }
        updateButtons();
    });

    prevButton.addEventListener('click', () => {
        if (currentPosition > 0) {
            currentPosition -= imgWidth;
            gallery.style.transform = `translateX(-${currentPosition}px)`;
        }
        updateButtons();
    });

    updateButtons();
};

// Setup Desktop and Mobile galleries
setupGallery('.desktop-gallery', 'desktopPrevButton', 'desktopNextButton', 400); // Desktop
setupGallery('.mobile-gallery', 'mobilePrevButton', 'mobileNextButton', 200); // Mobile
