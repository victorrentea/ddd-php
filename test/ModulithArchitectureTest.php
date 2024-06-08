<?php


use J6s\PhpArch\PhpArch;
use J6s\PhpArch\Validation\ForbiddenDependency;
use J6s\PhpArch\Validation\MustBeSelfContained;
use J6s\PhpArch\Validation\MustOnlyDependOn;
use PHPUnit\Framework\TestCase;

class ModulithArchitectureTest extends TestCase
{

    public function testSimpleNamespaces()
    {
        $directory = __DIR__ . '/../src/victor';
        echo "Reading from $directory";
        (new PhpArch())
            ->fromDirectory($directory)
            ->validate(new ForbiddenDependency('victor\\training\\onion\\view\\', 'victor\\training\\onion\\infra\\'))
//             ->validate(new MustBeSelfContained('App\\Utility'))
            // ->validate(new MustOnlyDependOn('App\\Mailing', 'PHPMailer\\PHPMailer'))
            ->assertHasNoErrors();
    }
}