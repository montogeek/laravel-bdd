<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Foundation\Testing\ApplicationTrait;
use PHPUnit_Framework_Assert as PHPUnit;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Defines application features from the specific context.
 */
class LaravelFeatureContext implements SnippetAcceptingContext
{
    use ApplicationTrait;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @BeforeScenario
     */
    public function setUp()
    {
        if( ! $this->app)
        {
            $this->refreshApplication();
        }
    }

    /**
     * Creates the application
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }
    /**
     * @Given I am logged in
     */
    public function iAmLoggedIn()
    {
        $user = new User;
        $this->be($user);
    }

    /**
     * @When I visit :arg1
     */
    public function iVisit($url)
    {
        $this->call('GET', $url);
    }

    /**
     * @Then I should see :arg1
     */
    public function iShouldSee($text)
    {
        $crawler = new Crawler($this->client->getResponse()->getContent());
        PHPUnit::assertCount(1, $crawler->filterXpath("//text()[. = '{$text}']"));
    }
}
