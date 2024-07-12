<?php

use JoshuaWebDev\TreatsSensibleData;
use PHPUnit\Framework\TestCase;

final class TreatsSensibleDataTest extends TestCase
{
    private $tsd;
    private $dataTest;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->tsd = new TreatsSensibleData();
        $this->dataTest = [
            [
                "ID"       => "1",
                "Name"     => "Phillipp Menier",
                "E-mail"   => "efoat3d@list-manage.com",
                "CPF_CNPJ" => "690.140.671-54"
            ],
            [
                "ID"       => "2",
                "Name"     => "Domini Lenton",
                "E-mail"   => "fabdee6u@unc.edu",
                "CPF_CNPJ" => "10.164.248/0001-28"
            ],
            [
                "ID"       => "3",
                "Name"     => "Willey Fissenden",
                "E-mail"   => "bpidler5y@booking.com",
                "CPF_CNPJ" => "10.684.352/0001-20"
            ],
            [
                "ID"       => "4",
                "Name"     => "Bertrand Morling",
                "E-mail"   => "aspata6c@redcross.org",
                "CPF_CNPJ" => "751.201.387-39"
            ],
            [
                "ID"       => "5",
                "Name"     => "Quinlan Estick",
                "E-mail"   => "sbohey1y@twitter.com",
                "CPF_CNPJ" => "247.126.746-63"
            ],
            [
                "ID"       => "6",
                "Name"     => "Matthew Wilber",
                "E-mail"   => "ccornish6r@arstechnica.com",
                "CPF_CNPJ" => "18.546.105/0006-83"
            ],
            [
                "ID"       => "7",
                "Name"     => "Vyky MacGoun",
                "E-mail"   => "rbenjefield53@bravesites.com",
                "CPF_CNPJ" => "11.099.764/0004-50"
            ],
            [
                "ID"       => "8",
                "Name"     => "Jennilee Sleite",
                "E-mail"   => "rpordals@usatoday.com",
                "CPF_CNPJ" => "447.727.955-68"
            ],
            [
                "ID"       => "9",
                "Name"     => "Marjory Eilles",
                "E-mail"   => "pludron5t@nymag.com",
                "CPF_CNPJ" => "892.046.972-67"
            ],
            [
                "ID"       => "10",
                "Name"     => "Rupert Morling",
                "E-mail"   => "ssiddons10@sfgate.com",
                "CPF_CNPJ" => "37.324.646/0001-50"
            ]
        ];
    }

    /**
     * @test
     * @return void
     */
    public function it_should_be_a_instanced_of_the_TreatsSensibleData_class(): void
    {
        $this->assertSame("JoshuaWebDev\TreatsSensibleData", get_class($this->tsd));
    }

    /**
     * @test
     * @return void
     */
    public function it_should_check_if_the_result_of_hideCPF_function_is_an_array(): void
    {
        $result = $this->tsd->hideCPF($this->dataTest, "CPF_CNPJ");
        $this->assertIsArray($result);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_remove_points_of_a_string(): void
    {
        $result1 = removePoints($this->dataTest[0]["CPF_CNPJ"]);
        $result2 = removePoints($this->dataTest[1]["CPF_CNPJ"]);
        $this->assertStringNotContainsString(".", $result1);
        $this->assertStringNotContainsString(".", $result2);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_remove_dash_of_a_string(): void
    {
        $result1 = removeDash($this->dataTest[0]["CPF_CNPJ"]);
        $result2 = removeDash($this->dataTest[1]["CPF_CNPJ"]);
        $this->assertStringNotContainsString("-", $result1);
        $this->assertStringNotContainsString("-", $result2);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_remove_slash_of_a_string(): void
    {
        $result = removeSlash($this->dataTest[1]["CPF_CNPJ"]);
        $this->assertStringNotContainsString("/", $result);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_check_if_the_size_of_the_result_of_hideCPF_function_with_cpf_param_is_equal_eleven(): void
    {
        $this->assertTrue(isCPF($this->dataTest[0]["CPF_CNPJ"]));
    }

    /**
     * @test
     * @return void
     */
    public function it_should_hide_the_six_digits_after_the_first_three(): void
    {
        $result = $this->tsd->hideCPF($this->dataTest, "CPF_CNPJ");
        $value1 = $result[0]["CPF_CNPJ"];
        $value2 = $result[1]["CPF_CNPJ"];

        $this->assertEquals(1, preg_match('/\d{3}\*{6}\d{2}/', $value1));
        // $this->assertEquals('blablablablabla', $value1);
        // $this->assertEquals('blablablablabla', $value2);
    }
}