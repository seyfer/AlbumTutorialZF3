<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 11/16/16
 */

namespace AlbumTest\Controller;


use Album\Controller\AlbumController;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Prophecy\Argument;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AlbumControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    protected $albumTable;

    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
        // Grabbing the full application configuration:
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $this->configureServiceManager($this->getApplicationServiceLocator());
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->albumTable->fetchAll()->willReturn([]);

        $this->dispatch('/album');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Album');
        $this->assertControllerName(AlbumController::class);
        $this->assertControllerClass('AlbumController');
        $this->assertMatchedRouteName('album');
    }

    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(AlbumTable::class, $this->mockAlbumTable()->reveal());

        $services->setAllowOverride(false);
    }

    protected function updateConfig($config)
    {
        $config['db'] = [];

        return $config;
    }

    protected function mockAlbumTable()
    {
        $this->albumTable = $this->prophesize(AlbumTable::class);

        return $this->albumTable;
    }

    public function testAddActionRedirectsAfterValidPost()
    {
        $this->albumTable
            ->saveAlbum(Argument::type(Album::class))
            ->shouldBeCalled();

        $postData = [
            'title'  => 'Led Zeppelin III',
            'artist' => 'Led Zeppelin',
            'id'     => '',
        ];
        $this->dispatch('/album/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/album');
    }

    //TODO: tests
    /*
     Test that a non-POST request to addAction() displays an empty form.
Test that a invalid data provided to addAction() re-displays the form, but with error messages.
Test that absence of an identifier in the route parameters when invoking either editAction() or deleteAction() will redirect to the appropriate location.
Test that an invalid identifier passed to editAction() will redirect to the album landing page.
Test that non-POST requests to editAction() and deleteAction() display forms.
     */

}