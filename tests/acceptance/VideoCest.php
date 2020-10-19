<?php

class VideoCest
{
    private $query = 'Тест';

    public function searchResultsOnVideoPageShouldBeCorrect(AcceptanceTester $I, \Page\Acceptance\Yandex $yandexPage)
    {
        $I->amOnPage($yandexPage->VIDEO_URL);
        $I->appendField($yandexPage->searchField, $this->query);
        $I->click($yandexPage->searchButton);
        $yandexPage->searchResultsShouldBeCorrect($this->query);
    }

    public function searchQueryShouldPassToVideoPageAfterClickOnTheTab(AcceptanceTester $I, \Page\Acceptance\Yandex $yandexPage)
    {
        $yandexPage->search($this->query);
        $I->seeElement($yandexPage->videoTab);
        $I->click($yandexPage->videoTab);
        $I->switchToNextTab();
        $I->seeInField($yandexPage->searchField, $this->query);
    }

    public function videoInRightColumnShouldNotPlayAfterSearch(AcceptanceTester $I, \Page\Acceptance\Yandex $yandexPage)
    {
        $I->amOnPage($yandexPage->VIDEO_URL);
        $I->appendField($yandexPage->searchField, $this->query);
        $I->click($yandexPage->searchButton);
        $I->dontSeeElement($yandexPage->playedVideoInRightColumn);
    }

    public function videoShouldAutoplayAfterClickOnTheSearchResult(AcceptanceTester $I, \Page\Acceptance\Yandex $yandexPage)
    {
        $I->amOnPage($yandexPage->VIDEO_URL);
        $I->appendField($yandexPage->searchField, $this->query);
        $I->click($yandexPage->searchButton);
        $yandexPage->videoShouldStartPlayingAfterClickOnThumbnail();
    }
}
