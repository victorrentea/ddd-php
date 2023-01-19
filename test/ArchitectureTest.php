<?php


use J6s\PhpArch\PhpArch;
use J6s\PhpArch\Validation\ForbiddenDependency;
use J6s\PhpArch\Validation\MustBeSelfContained;
use J6s\PhpArch\Validation\MustOnlyDependOn;

// class Test1 extends \J6s\PhpArch\Tests\TestCase
class ArchitectureTest extends \PHPUnit\Framework\TestCase
{

    // NOTE: In case you don't understand this test, contact me:
    // +40720019564 or victorrentea@gmail.com (the anarchitect)
    public function testSimpleNamespaces()
    {
        $directory = __DIR__ . '/../src/victor';
        echo "Reading from $directory";
        (new PhpArch())
            ->fromDirectory($directory)
            ->validate(new ForbiddenDependency('victor\\training\\onion\\domain\\service\\', 'victor\\training\\onion\\infra\\'))
            // ->validate(new MustBeSelfContained('App\\Utility'))
            // ->validate(new MustOnlyDependOn('App\\Mailing', 'PHPMailer\\PHPMailer'))
            ->assertHasNoErrors();
    }
}