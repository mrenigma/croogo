<?php
App::import('Model', 'Node');

class MetaBehaviorTestCase extends CakeTestCase {

    var $fixtures = array(
        'aco',
        'aro',
        'aros_aco',
        'block',
        'comment',
        'contact',
        'i18n',
        'language',
        'link',
        'menu',
        'message',
        'meta',
        'node',
        'nodes_term',
        'region',
        'role',
        'setting',
        'term',
        'type',
        'types_vocabulary',
        'user',
        'vocabulary',
    );

    function startTest() {
        $this->Node =& ClassRegistry::init('Node');
    }

    function testSingle() {
        $about = $this->Node->findBySlug('about');
        $this->assertEqual($about['CustomFields']['meta_keywords'], 'key1, key2');
    }

    function testMultiple() {
        $result = $this->Node->find('all', array(
            'order' => 'Node.id ASC',
        ));
        $this->assertEqual($result['0']['CustomFields']['meta_keywords'], 'key1, key2');
    }

    function testPrepareMeta() {
        $data = array(
            'Meta' => array(
                String::uuid() => array(
                    'key' => 'key1',
                    'value' => 'value1',
                ),
                String::uuid() => array(
                    'key' => 'key2',
                    'value' => 'value2',
                ),
            ),
        );
        $this->assertEqual($this->Node->prepareData($data), array(
            'Meta' => array(
                '0' => array(
                    'key' => 'key1',
                    'value' => 'value1',
                ),
                '1' => array(
                    'key' => 'key2',
                    'value' => 'value2',
                ),
            ),
        ));
    }

    function endTest() {
        unset($this->Node);
        ClassRegistry::flush();
    }
}
?>