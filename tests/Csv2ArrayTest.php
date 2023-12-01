<?php

use JoshuaWebDev\Csv2Array;
use PHPUnit\Framework\TestCase;

final class Csv2ArrayTest extends TestCase
{
    private $csv2array;
    private $headers;
    private $testFile;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->csv2array = new Csv2Array();
        $this->headers = [
            'ID',
            'Name',
            'E-mail',
            'Role',
            'Razao_Social',
            'CPF_CNPJ'
        ];
        $this->testFile = 'tests/test.csv';
    }
    
    /**
     * @test
     * @return void
     */
    public function it_should_be_a_instanced_of_the_Csv2Array_class(): void
    {
        $this->assertSame("JoshuaWebDev\Csv2Array", get_class($this->csv2array));
    }

    /**
     * @test
     * @return void
     */
    public function it_should_be_able_to_assign_a_separator(): void
    {
        $this->csv2array->setSeparator(";");
        $this->assertEquals(";", $this->csv2array->getSeparator());
    }

    /**
     * @test
     * @return void
     */
    public function it_should_be_able_to_set_quotes(): void
    {
        $this->csv2array->setQuotes('"');
        $this->assertEquals('"', $this->csv2array->getQuotes());
    }

    /**
     * @test
     * @return void
     */
    public function it_should_to_define_the_header(): void
    {
        $this->csv2array->setHeaders($this->headers);
        $this->assertEquals($this->csv2array->getHeaders(), $this->headers);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_convert_csv_file_to_array(): void
    {
        $result = $this->csv2array->convertToArray($this->testFile);

        $this->assertEquals('array', gettype($result));
        $this->assertEquals('array', gettype($this->csv2array->getHeaders()));
        $this->assertEquals($this->headers, $this->csv2array->getHeaders());
    }

    /**
     * @test
     * @return void
     */
    public function it_should_get_the_output_path(): void
    {
        $path = $this->csv2array->getOutPutPath();
        $expected = 'output/';

        $this->assertEquals($expected, $path);
    }
}
