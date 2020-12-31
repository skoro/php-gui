<?php declare(strict_types=1);

namespace TclTk\Tests;

use PHPUnit\Framework\TestCase as FrameworkTestCase;
use TclTk\App;
use TclTk\Widgets\TkWidget;
use TclTk\Widgets\Window;

class TestCase extends FrameworkTestCase
{
    protected $app;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app = $this->createAppMock();
    }

    protected function createAppMock()
    {
        return $this->createMock(App::class);
    }

    public function createWindowStub(): TkWidget
    {
        $win = $this->createStub(Window::class);
        $win->method('app')->willReturn($this->app);
        $win->method('window')->willReturnSelf();
        return $win;
    }
}
