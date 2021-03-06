<?php
// @TODO: Copied from /drupal/drupal-extension/src/Drupal/DrupalExtension/Context/ContextClass/ClassGenerator.php
// We would like to make our own, not sure how yet.


namespace Drupal\DrupalExtension\Context\ContextClass;
namespace DevShop\Behat\DrupalExtension\Context\ContextClass;

use Behat\Behat\Context\ContextClass\ClassGenerator as BehatClassGenerator;
use Behat\Testwork\Suite\Suite;

/**
 * Generates a starting class that extends the RawDrupalContext.
 */
class ClassGenerator implements BehatClassGenerator {

  /**
   * @var string
   */
  protected static $template = <<<'PHP'
<?php

{namespace}use DevShop\Behat\DrupalExtension\Context\DevShopDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class {className} extends DevShopDrupalContext implements SnippetAcceptingContext {

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct() {
  }

}

PHP;

  /**
   * {@inheritdoc}
   */
  public function supportsSuiteAndClass(Suite $suite, $contextClass) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function generateClass(Suite $suite, $contextClass) {
    $fqn = $contextClass;

    $namespace = '';
    if (false !== $pos = strrpos($fqn, '\\')) {
      $namespace = 'namespace ' . substr($fqn, 0, $pos) . ";\n\n";
      $contextClass = substr($fqn, $pos + 1);
    }

    return strtr(
      static::$template,
      array(
        '{namespace}' => $namespace,
        '{className}' => $contextClass,
      )
    );
  }
}
