import Swiper from 'swiper';
import 'swiper/swiper-bundle.css';
import { Navigation } from 'swiper/modules';

// import Swiper from 'swiper/swiper-bundle';
// import 'swiper/swiper-bundle.css';

export default class SwiperWidget {
    constructor() {
        this.init();
    }

    init() {
        console.log('SwiperWidget initialized');
        const swiperContainer = document.querySelector('.artist__swiper');
        const nextButton = document.querySelector('.swiper-button-next');

        if (swiperContainer && nextButton) {
            console.log('Swiper container and navigation button found');
            Swiper.use([Navigation]);
            const swiper = new Swiper(swiperContainer, {
                loop: true,
                // navigation: {
                //     nextEl: nextButton,
                // },
                // slidesPerView: 1,
                // spaceBetween: 10,
            });
        } else {
            console.error('Swiper container or navigation button not found');
        }
    }
}