// Imports web stylesheet
import '../scss/web.scss';

const $ = require('jquery');

/**
 * Pause and start video.
 *
 * @param $oldSlide
 * @param $newSlide
 */
function pauseAndStartVideo($oldSlide, $newSlide) {
    let $oldVideo = $oldSlide.find('video');
    let $newVideo = $newSlide.find('video');

    if ($oldVideo.length > 0) {
        $oldVideo.get(0).pause();
    }

    if ($newVideo.length > 0) {
        $newVideo.get(0).currentTime = 0;
        $newVideo.get(0).play();
    }
}

/**
 *  Toggle slide
 * @param $oldSlide
 * @param $newSlide
 */
function toggleSlide($oldSlide, $newSlide) {
    $oldSlide.removeClass('shown');
    $newSlide.addClass('shown');
    pauseAndStartVideo($oldSlide, $newSlide)
}

/**
 * Refresh slides.
 */
function refreshSlides() {
    const currentUrl = window.location.href;
    $.ajax({
        url: currentUrl,
        type: 'GET',
        success: function (data) {
            const $slideShow = $('.js-slideshow');
            const $currentSlideshow = $slideShow.children();
            const $newSlideshow = $(data).children($slideShow);

            if($currentSlideshow.length !== $newSlideshow.length){
                $currentSlideshow.parent().html($newSlideshow);
            }
        }
    });
}

setInterval(function () {
    // Gets current slideshow item
    let $currentSlideshowItem = $('.js-slideshow-item.shown');

    // Gets next slideshow item
    let $nextSlideshowItem = $currentSlideshowItem.next();

    // If not exists - repeat
    if ($nextSlideshowItem.length === 0) {
        refreshSlides();
        let $firstSlideshowItem = $currentSlideshowItem.parent().children(':first-child');
        toggleSlide($currentSlideshowItem, $firstSlideshowItem);
        return;
    }

    // Show next slide
    toggleSlide($currentSlideshowItem, $nextSlideshowItem);
}, 10000);

