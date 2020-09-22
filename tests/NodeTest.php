<?php


use smn\hnp\Node;
use PHPUnit\Framework\TestCase;

class myNodeId extends Node
{

    protected array $unique_properties = ['id'];

}


class NodeTest extends TestCase
{


    public function testIsKeyAndValueMandatoryPresentBig() {
        $data = [
            [
                // 1
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'anotherName',
                    'type' => 'foobar',
                    'noMandatory' => 'fake'
                ],
                'expect' => false
            ],
            [
                // 2
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'fake'
                ],
                'expect' => true
            ],
            [
                // 3
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtypessss',
                    'noMandatory' => 'fake'
                ],
                'expect' => false
            ],
            [
                // 4
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtypesss',
                    'noMandatory' => 'value'
                ],
                'expect' => false
            ],
            [
                // 5
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtype'
                ],
                'expect' => true
            ],
            [
                // 6
                'unique' => [
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtype'
                ],
                'expect' => true
            ],
        ];

        foreach ($data as $d) {
            $unique = $d['unique'];
            $properties = $d['properties'];
            $send = $d['send'];
            $expect = $d['expect'];
            $obj = new Node('fakeValue', []);
            $reflection = new ReflectionClass($obj);

            $property = $reflection->getProperty('unique_properties');
            $property->setAccessible(true);
            $property->setValue($obj, $unique);

            $property = $reflection->getProperty('properties');
            $property->setAccessible(true);
            $property->setValue($obj, $properties);

            if ($expect) {
                $this->assertTrue($obj->isKeyAndValueMandatoryPresent($send));
            } else {
                $this->assertFalse($obj->isKeyAndValueMandatoryPresent($send));
            }

        }
    }

    public function testIsMandatoryPresentBig()
    {

        $data = [
            [
                // 1
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'anotherName',
                    'type' => 'foobar',
                    'noMandatory' => 'fake'
                ],
                'expect' => true
            ],
            // 2
            [
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'fake'
                ],
                'expect' => true
            ],
            [
                // 3
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'type' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'types' => 'objtypes',
                    'noMandatory' => 'fake'
                ],
                'expect' => false
            ],
            [
                // 4
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'types' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'types' => 'objtypes',
                    'noMandatory' => 'value'
                ],
                'expect' => false
            ],
            [
                // 5
                'unique' => [
                    'name',
                    'type'
                ],
                'properties' => [
                    'name' => 'selfname',
                    'types' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtype'
                ],
                'expect' => true
            ],
            [
                // 6
                'unique' => [
                ],
                'properties' => [
                    'name' => 'selfname',
                    'types' => 'objtype',
                    'noMandatory' => 'value'
                ],
                'send' => [
                    'name' => 'selfname',
                    'type' => 'objtype'
                ],
                'expect' => true
            ],

        ];

        foreach ($data as $d) {
            $unique = $d['unique'];
            $properties = $d['properties'];
            $send = $d['send'];
            $expect = $d['expect'];
            $obj = new Node('fakeValue', []);
            $reflection = new ReflectionClass($obj);

            $property = $reflection->getProperty('unique_properties');
            $property->setAccessible(true);
            $property->setValue($obj, $unique);

            $property = $reflection->getProperty('properties');
            $property->setAccessible(true);
            $property->setValue($obj, $properties);

            if ($expect) {
                $this->assertTrue($obj->isKeyMandatoryPresent($send));
            } else {
                $this->assertFalse($obj->isKeyMandatoryPresent($send));
            }

        }


    }


    public function testGetMandatoryPropertiesKeyValue()
    {
        $value = 10;
        $obj = new Node($value, []);
        $reflection = new ReflectionClass($obj);

        $property = $reflection->getProperty('unique_properties');
        $property->setAccessible(true);
        $property->setValue($obj, ['id']);

        $property = $reflection->getProperty('properties');
        $property->setAccessible(true);
        $property->setValue($obj, ['id' => 5, 'test' => 'value', 'foo' => 'bar']);

        $this->assertEquals(['id' => 5], $obj->getMandatoryPropertiesKeyValue());


    }

    public function testHasParent()
    {
        $node = new myNodeId(5, ['id' => 10, 'foo' => 'bar']);
        $node->addNode(10, ['id' => 111]);
        $child = $node->getNode(['id' => 111]);

        $this->assertEquals($child->getParent(), $node);
        $this->assertEquals($child->getAncestral(), $node);
        $this->assertTrue($child->hasParent());
        $this->assertFalse($node->hasParent());


    }

    public function testSetValue()
    {
        $value = 5;
        $node = new Node($value);
        $this->assertEquals($value, $node->getValue());
        $value = 10;
        $node->setValue($value);
        $this->assertEquals($value, $node->getValue());

    }

    public function test__construct()
    {
        $properties = ['id' => 5];
        $value = 10;
        $node = new Node($value, $properties);
        $this->assertCount(0, $node->getMandatoryPropertiesKey());

    }

    public function testIsKeyMandatoryPresent()
    {
        $value = 10;
        $obj = new Node($value, []);
        $reflection = new ReflectionClass($obj);

        $property = $reflection->getProperty('unique_properties');
        $property->setAccessible(true);
        $property->setValue($obj, ['id']);

        $this->assertTrue($obj->isKeyMandatoryPresent(['id' => 10, 'foo' => 'bar']));
        $this->assertTrue($obj->isKeyMandatoryPresent(['id' => 10]));
        $this->assertFalse($obj->isKeyMandatoryPresent(['foo' => 10]));

    }

    public function testGetValue()
    {
        $value = 5;
        $node = new Node($value);
        $this->assertEquals($value, $node->getValue());

    }

    public function testGetNodes()
    {
        $parent = new myNodeId(5, ['id' => 5]);
        $parent->addNode(10, ['id' => 10]);
        $parent->addNode(10, ['id' => 11, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 12, 'test' => 'value']);
        $parent->addNode(10, ['id' => 13, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 14]);

        $nodes = $parent->getNodes(['foo' => 'bar']);

        $this->assertCount(2, $nodes);
        $node_1 = $nodes[0];
        $node_2 = $nodes[1];
        $this->assertEquals('bar', $node_1->getProperty('foo'));
        $this->assertEquals(11, $node_1->getProperty('id'));
        $this->assertEquals('bar', $node_2->getProperty('foo'));
        $this->assertEquals(13, $node_2->getProperty('id'));


    }

    public function testHasProperty()
    {
        $value = 5;
        $node = new Node($value);
        $this->assertFalse($node->hasProperty('id'));
        $node->setProperty('id', 10);
        $this->assertTrue($node->hasProperty('id'));

    }

    public function testSetProperty()
    {
        $value = 5;
        $node = new Node($value);
        $node->setProperty('id', 10);
        $this->assertEquals(10, $node->getProperty('id'));
    }

    public function testAddNodeNoMandatoryKey()
    {
        $value = 10;
        $obj_parent = new Node($value, []);
        $reflection = new ReflectionClass($obj_parent);

        /* creazione padre */
        $property = $reflection->getProperty('unique_properties');
        $property->setAccessible(true);
        $property->setValue($obj_parent, ['id']);

        $property = $reflection->getProperty('properties');
        $property->setAccessible(true);
        $property->setValue($obj_parent, ['id' => 5]);


        /* creazione figlio */
        $this->expectException(\smn\hnp\NodeException::class);
        $obj_parent->addNode(20);

    }

    public function testAddNodeOnlyMandatoryKeyChildrenSameValueParent()
    {
        $value = 10;
        $obj_parent = new Node($value, []);
        $reflection = new ReflectionClass($obj_parent);

        /* creazione padre */
        $property = $reflection->getProperty('unique_properties');
        $property->setAccessible(true);
        $property->setValue($obj_parent, ['id']);

        $property = $reflection->getProperty('properties');
        $property->setAccessible(true);
        $property->setValue($obj_parent, ['id' => 5]);

        $this->expectException(\smn\hnp\NodeException::class);
        $this->expectExceptionMessage('le proprietà obbligatorie del figlio sono le stesse del padre');
        $obj_parent->addNode(20, ['id' => 5]);

    }

    public function testAddNodeOnlyMandatoryKeyWithCorrectValue()
    {
        $value = 10;
        $obj_parent = new Node($value, []);
        $reflection = new ReflectionClass($obj_parent);

        /* creazione padre */
        $property = $reflection->getProperty('unique_properties');
        $property->setAccessible(true);
        $property->setValue($obj_parent, ['id']);

        $property = $reflection->getProperty('properties');
        $property->setAccessible(true);
        $property->setValue($obj_parent, ['id' => 5]);

        $obj_parent->addNode(20, ['id' => 10]);
        $this->assertCount(1, $obj_parent->getChildren());

    }

    public function testRemoveNode()
    {
        $value = 10;
        $obj_parent = new myNodeId($value, ['id' => 5]);

        $obj_parent->addNode(20, ['id' => 10]);
        $this->assertCount(1, $obj_parent->getChildren());

        $obj_parent->removeNode([]);
        $this->assertCount(1, $obj_parent->getChildren());

        $obj_parent->removeNode(['id' => 5]);
        $this->assertCount(1, $obj_parent->getChildren());

        $obj_parent->removeNode(['id' => 10]);
        $this->assertCount(0, $obj_parent->getChildren());

    }

    public function testGetPropertiesKey()
    {
        $value = 5;
        $node = new Node($value, ['id' => 10, 'name' => 'test']);
        $this->assertEquals(['id', 'name'], $node->getPropertiesKey());

    }

    public function testRemoveChildren()
    {
        $parent = new myNodeId(5, ['id' => 5]);
        $parent->addNode(10, ['id' => 10]);
        $parent->addNode(10, ['id' => 11, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 12, 'test' => 'value']);
        $parent->addNode(10, ['id' => 13, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 14]);

        $this->assertCount(5, $parent->getChildren());
        $parent->removeChildren(['foo' => 'bar']);
        $this->assertCount(3, $parent->getChildren());
        $parent->removeChildren(['test' => 'value', 'foo' => 'bar']);
        $this->assertCount(3, $parent->getChildren());
        $parent->removeChildren(['test' => 'value', 'id' => 13]);
        $this->assertCount(3, $parent->getChildren());
        $parent->removeChildren(['test' => 'value', 'id' => 12]);
        $this->assertCount(2, $parent->getChildren());
    }

    public function testGetAncestral()
    {
        $parent = new myNodeId(5, ['id' => 5]);
        $parent->addNode(10, ['id' => 10]);
        $child = $parent->getNode(['id' => 10]);
        $child->addNode(15, ['id' => 20]);
        $n = $child->getNode(['id' => 20]);

        $this->assertEquals($n->getAncestral(), $parent);


    }

    public function testGetMandatoryPropertiesKey()
    {
        $value = 5;
        $node = new Node($value, ['id' => 10, 'name' => 'test']);
        $this->assertEquals([], $node->getMandatoryPropertiesKey());

        $obj = new Node($value, []);
        $reflection = new ReflectionClass($obj);

        $property = $reflection->getProperty('unique_properties');
        $property->setAccessible(true);
        $property->setValue($obj, ['id']);

        $property = $reflection->getProperty('properties');
        $property->setAccessible(true);
        $property->setValue($obj, ['id' => 10, 'name' => 'test']);

        $this->assertEquals(['id'], $obj->getMandatoryPropertiesKey());


    }

    public function testRemoveChildrenByValue()
    {
        $parent = new myNodeId(5, ['id' => 5]);
        $parent->addNode(10, ['id' => 10]);
        $parent->addNode(10, ['id' => 11, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 12, 'test' => 'value']);
        $parent->addNode(10, ['id' => 13, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 14]);

        $this->assertCount(5, $parent->getChildren());
        $parent->removeChildrenByValue(10);
        $this->assertCount(0, $parent->getChildren());

    }

    public function testSetParent()
    {
        $child = new myNodeId(5, ['id' => 5]);
        $child->setParent(10, ['id' => 10]);

        $this->assertEquals(10, $child->getParent()->getValue());


    }

    public function testGetCountChildren()
    {
        $parent = new myNodeId(5, ['id' => 5]);
        $parent->addNode(10, ['id' => 10]);
        $parent->addNode(10, ['id' => 11, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 12, 'test' => 'value']);
        $parent->addNode(10, ['id' => 13, 'foo' => 'bar']);
        $parent->addNode(10, ['id' => 14]);

        $this->assertCount(5, $parent->getChildren());
        $this->assertEquals(5, $parent->getCountChildren());

    }

    public function testGetProperty()
    {
        $value = 5;
        $node = new Node($value, ['id' => 10, 'name' => 'test']);
        $this->assertEquals(10, $node->getProperty('id'));
        $this->assertEquals('test', $node->getProperty('name'));
    }

    public function testGetParent()
    {

        $node = new myNodeId(5, ['id' => 10, 'foo' => 'bar']);
        $node->addNode(10, ['id' => 111]);
        $child = $node->getNode(['id' => 111]);

        $this->assertEquals($node, $child->getParent());

    }

    public function testIsMandatoryKey()
    {
        $value = 10;
        $node = new myNodeId($value, ['id' => 5, 'foo' => 'bar']);

        $this->assertTrue($node->isMandatoryKey('id'));
        $this->assertFalse($node->isMandatoryKey('foo'));

    }

    public function testIsKeyAndValueMandatoryPresent()
    {
        $value = 10;
        $node = new myNodeId($value, ['id' => 5, 'foo' => 'bar']);

        $this->assertTrue($node->isKeyAndValueMandatoryPresent(['id' => 5, 'foo' => 'bar']));
        $this->assertTrue($node->isKeyAndValueMandatoryPresent(['id' => 5, 'foo' => 'bars']));
        $this->assertFalse($node->isKeyAndValueMandatoryPresent(['id' => 3, 'foo' => 'bar']));
    }

    public function testGetProperties()
    {
        $value = 5;
        $node = new Node($value, ['id' => 10, 'name' => 'test']);
        $this->assertEquals(['id' => 10, 'name' => 'test'], $node->getProperties());
    }

    public function testGetNode()
    {
        $parent = new myNodeId(5, ['id' => 5]);
        $parent->addNode(10, ['id' => 10]);
        $child = $parent->getNode(['id' => 10]);
        $child->addNode(15, ['id' => 20]);
        $n = $child->getNode(['id' => 20]);

        $this->assertInstanceOf(myNodeId::class, $n);
    }
}
