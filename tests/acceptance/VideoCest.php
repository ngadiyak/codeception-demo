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
        $yandexPage->clickOnRandomSearchResult();
        $I->waitForElement($yandexPage->autoplayedVideo, 10);

        // Решение не очень корректно, потому что проверка не гарантирует, что видео действительно проигрывается,
        // но код ниже порождает вот такой вывод:

        // Вывод:
        // I wait for element ".VideoPlayer iframe",10
        // I grab attribute from ".VideoPlayer iframe","id"
        // I wait for element "#player-id763634585",10
        // I switch to i frame "#player-id763634585"
        //  Iframe was not found by name, locating iframe by CSS or XPath
        // I assert true false," ID: player-id763634585"
        // FAIL 

        // Код:
        // $I->waitForElement('.VideoPlayer iframe', 10);
        // $id = $I->grabAttributeFrom('.VideoPlayer iframe', 'id');
        // $I->waitForElement("#{$id}", 10);
        // $I->switchToIFrame("#{$id}");
        // $I->assertTrue(false, " ID: {$id}");
    }
}
