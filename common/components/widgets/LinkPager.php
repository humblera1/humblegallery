<?php

namespace common\components\widgets;

use yii\widgets\LinkPager as BaseLinkPager;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Кастомный LinkPager с отображением троеточия ("...") в разрыве страниц.
 * Пример (100 страниц, текущая 5-я): 1 ... 4 5 6 ... 100.
 */
class LinkPager extends BaseLinkPager
{
    public string $separatorContainerClass = 'separator-container';

    public string $separatorContentClass = 'separator';

    public string $separatorContent = '...';

    /**
     * Выполняет рендеринг кнопок пагинации.
     * @return string
     */
    protected function renderPageButtons(): string
    {
        $pageCount = $this->pagination->getPageCount();
        $currentPage = $this->pagination->getPage();

        // Если всего одна страница и включено hideOnSinglePage — ничего не выводим
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];

        // Преобразуем для удобства к 1-based
        $currentPageOneBased = $currentPage + 1;

        $firstClass = $this->mergeClasses($this->pageCssClass, $this->firstPageCssClass);

        // Всегда показываем первую страницу (в примере это "1")
        $buttons[] = $this->renderPageButton(
            1,
            0,
            $firstClass,
            false,
            $currentPage == 0
        );

        // Если между первой страницей и (currentPage - 1) есть разрыв больше 1 страницы, добавим "..."
        if ($currentPageOneBased > 3) {
            $buttons[] = $this->renderSeparator();
        }

        // Если можем отобразить предыдущую страницу числом (и она не первая)
        if ($currentPageOneBased - 1 > 1) {
            $buttons[] = $this->renderPageButton(
                $currentPageOneBased - 1,
                $currentPage - 1,
                null,
                false,
                false
            );
        }

        // Текущая страница (если она не первая и не последняя — тогда показывать есть смысл)
        if ($currentPageOneBased > 1 && $currentPageOneBased < $pageCount) {
            $buttons[] = $this->renderPageButton(
                $currentPageOneBased,
                $currentPage,
                null,
                false,
                true // активная
            );
        }

        // Следующая страница числом (если можем)
        if ($currentPageOneBased + 1 < $pageCount) {
            $buttons[] = $this->renderPageButton(
                $currentPageOneBased + 1,
                $currentPage + 1,
                null,
                false,
                false
            );
        }

        // Если впереди до последней страницы есть разрыв больше 1 — добавим "..."
        if ($currentPageOneBased < $pageCount - 2) {
            $buttons[] = $this->renderSeparator();
        }

        // Собираем класс для последней страницы
        $lastClass = $this->mergeClasses($this->pageCssClass, $this->lastPageCssClass);

        $buttons[] = $this->renderPageButton(
            $pageCount,
            $pageCount - 1,
            $lastClass,
            false,
            $currentPage == $pageCount - 1
        );

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');

        return Html::tag($tag, implode("\n", $buttons), $options);
    }

    /**
     * Вывод "..." как недоступной кнопки (disabled).
     * @return string
     */
    protected function renderSeparator(): string
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');

        $classes = $this->mergeClasses($this->disabledPageCssClass, $this->separatorContainerClass);
        Html::addCssClass($options, $classes);

        $ellipsisTagOptions = $this->disabledListItemSubTagOptions;
        $tag = ArrayHelper::remove($ellipsisTagOptions, 'tag', 'span');

        Html::addCssClass($ellipsisTagOptions, $this->separatorContentClass);

        return Html::tag($linkWrapTag, Html::tag($tag, $this->separatorContent, $ellipsisTagOptions), $options);
    }

    /**
     * Объединяет несколько классов (если они переданы).
     */
    private function mergeClasses(?string $class1, ?string $class2): ?string
    {
        if (!$class1 && !$class2) {
            return null;
        }
        $classes = [];
        if ($class1) {
            $classes[] = $class1;
        }
        if ($class2) {
            $classes[] = $class2;
        }
        return implode(' ', $classes);
    }
}