<?php

namespace TJVB\PackagistTile\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use TJVB\PackagistTile\PackageData;

class PackageDataTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     *
     * @test
     */
    public function weCanCreateAPackageDataObject(): void
    {
        // Arrange: create dependencies and test doubles
        $name = $this->faker()->word;
        $downloadsDaily = $this->faker()->numberBetween();
        $downloadsMonthly = $this->faker()->numberBetween();
        $downloadsTotal = $this->faker()->numberBetween();
        $favers = $this->faker()->numberBetween();
        $githubStars = $this->faker()->numberBetween();
        $abandoned = $this->faker()->boolean;

        // Act: Execute the code
        $packageData = new PackageData(
            $name,
            $downloadsDaily,
            $downloadsMonthly,
            $downloadsTotal,
            $favers,
            $githubStars,
            $abandoned
        );

        // Assert: Verify the result of the code
        $this->assertEquals($name, $packageData->getName());
        $this->assertEquals($downloadsDaily, $packageData->getDailyDownloads());
        $this->assertEquals($downloadsMonthly, $packageData->getMonthlyDownloads());
        $this->assertEquals($downloadsTotal, $packageData->getTotalDownloads());
        $this->assertEquals($favers, $packageData->getFavers());
        $this->assertEquals($githubStars, $packageData->getGithubStars());
        $this->assertEquals($abandoned, $packageData->getAbandoned());
    }

    /**
     * @return void
     *
     * @test
     */
    public function weCanCreateAPackageDataObjectFromAnArray(): void
    {
        // Arrange: create dependencies and test doubles
        $array = require self::FIXTURES_PATH . 'packagedataArray.php';

        // Act: Execute the code
        $packageData = PackageData::fromArray($array);

        // Assert: Verify the result of the code
        $this->assertEquals($array['name'], $packageData->getName());
        $this->assertEquals($array['downloadsDaily'], $packageData->getDailyDownloads());
        $this->assertEquals($array['downloadsMonthly'], $packageData->getMonthlyDownloads());
        $this->assertEquals($array['downloadsTotal'], $packageData->getTotalDownloads());
        $this->assertEquals($array['favers'], $packageData->getFavers());
        $this->assertEquals($array['github_stars'], $packageData->getGithubStars());
        $this->assertEquals($array['abandoned'], $packageData->getAbandoned());
    }

    /**
     * @return void
     *
     * @depends weCanCreateAPackageDataObjectFromAnArray
     *
     * @test
     */
    public function weCanGetAnArrayWithDataFromAPacakgeDataObject(): void
    {
        // Arrange: create dependencies and test doubles
        $array = require self::FIXTURES_PATH . 'packagedataArray.php';

        // Act: Execute the code
        $packageData = PackageData::fromArray($array);
        $resultArray = $packageData->toArray();

        // Assert: Verify the result of the code
        $this->assertEquals($array, $resultArray);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weCanCreateAPackageDataObjectFromPackagistData(): void
    {
        // Arrange: create dependencies and test doubles
        $packagistJson = file_get_contents(self::FIXTURES_PATH . 'packagistMetaData.json');
        $packagistData = json_decode($packagistJson, true);

        // Act: Execute the code
        $packageData = PackageData::fromPackagistMetaData($packagistData);

        // Assert: Verify the result of the code
        $this->assertEquals('tjvb/laravel-mail-catchall', $packageData->getName());
        $this->assertEquals(39, $packageData->getDailyDownloads());
        $this->assertEquals(993, $packageData->getMonthlyDownloads());
        $this->assertEquals(13059, $packageData->getTotalDownloads());
        $this->assertEquals(1, $packageData->getFavers());
        $this->assertEquals(0, $packageData->getGithubStars());
        $this->assertEquals(false, $packageData->getAbandoned());
    }
}
