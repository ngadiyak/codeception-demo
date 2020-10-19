<?php

namespace Page\Acceptance;

class Yandex
{
    public $SEARCH_URL = '/search/?text=';
    public $VIDEO_URL = '/video';

    public $searchField = 'input[name=text]';
    public $videoTab = '.service_name_video a';
    public $searchButton = '.search2__button button';
    public $searchItem = '.serp-list__items > :nth-child(%d)';
    public $searchItemSing = '.serp-item';
    public $searchItemTitle = '.serp-list__items > :nth-child(%d) .serp-item__title';
    public $thumbVideoInRightColumn = '.Carousel-Content .VideoThumbPreview';
    public $playedVideoInRightColumn = '.Carousel-Content .VideoThumbPreview > :nth-child(1)';
    public $autoplayedVideo = '.VideoPlayer [allow*="autoplay"]';


    protected $I;

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    public function search($query = '')
    {
        $this->I->amOnPage("{$this->SEARCH_URL}{$query}");
    }

    public function clickOnRandomSearchResult()
    {
        $count = count($this->I->grabMultiple($this->searchItemSing));
        $locator = str_replace('%d', random_int(1, $count), $this->searchItem);
        $this->I->seeElement($locator);
        $this->I->click($locator);
    }

    public function searchResultsShouldBeCorrect(String $query)
    {
        $count = count($this->I->grabMultiple($this->searchItemSing));

        $this->I->assertTrue($count > 0, 'Не найдены результаты поиска');

        for ($i = 1; $i <= $count / 5; $i++) {
            $locator = str_replace('%d', random_int(1, $count), $this->searchItemTitle);
            $this->I->seeElement($locator);
            $title = $this->I->grabTextFrom($locator);
            $this->I->assertStringContainsString(mb_strtolower($query), mb_strtolower($title), 'Результат поиска не соответствует запросу');
        }
    }
}
