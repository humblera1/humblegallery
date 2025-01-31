import Swiper from 'swiper';
import 'swiper/swiper-bundle.css';
import { Navigation } from 'swiper/modules';
import * as styles from './styles.scss';

export default new class SwiperWidget {
    constructor() {
        if ($('#swiper-widget').length > 0) {
            this.init();
        }
    }

    init() {
        const swiperContainer = document.querySelector('.swiper-container');
        const nextButton = document.querySelector('.swiper-button-next');

        if (swiperContainer && nextButton) {
            Swiper.use([Navigation]);

            const swiper = new Swiper(swiperContainer, {
                navigation: {
                    nextEl: nextButton,
                },
                slidesPerView: 'auto',
                spaceBetween: 16,
            });
        } else {
            // todo: обработка ошибки
            console.error('Swiper container or navigation button not found');
        }
    }
}()