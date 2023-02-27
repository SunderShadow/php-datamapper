<?php

class DataMapperTest extends \PHPUnit\Framework\TestCase
{
    private array $data = [
        'strings' => [
            'subkey' => 'str',
            'subkey2' => 'str2',
            'subkey3' => 'str3'
        ],
        'integers' => [1, 2, 3],
        'mixed' => [
            'string' => 'str',
            'integer' => 3,
            'array' => [
                'string',
                'string',
                'string'
            ]
        ]
    ];

    public function test_single_item()
    {
        $mapper = new \Sander\Data\DataMapper($this->data);
        $this->assertEquals($this->data['strings']['subkey'], $mapper->get('strings.subkey')->current());
    }

    public function test_multiple_items()
    {
        $mapper = new \Sander\Data\DataMapper($this->data);

        $i = 0;
        foreach ($mapper->get('integers.*') as $it) {
            if ($it !== $this->data['integers'][$i++]) {
                $this->fail();
            }
        }

        $this->assertTrue(true);
    }

    public function test_multiple_each_item()
    {
        $mapper = new \Sander\Data\DataMapper([
            [
                [
                    1, 2, 3
                ]
            ],
            [
                [
                    4, 5, 6
                ]
            ]
        ]);

        $i = 0;
        $expect = [1, 2, 3, 4, 5, 6];

        foreach ($mapper->get('*.*.*') as $it) {
            if ($it !== $expect[$i++]) {
                $this->fail();
            }
        }

        $this->assertTrue(true);
    }
}