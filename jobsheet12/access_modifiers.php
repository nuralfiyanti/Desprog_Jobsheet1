<?php
class Animal {
    public $name;
    protected $age;
    private $color;

    public function __construct($name, $age, $color) {
        $this->name = $name;
        $this->age = $age;
        $this->color = $color;
    }

    public function getName() {
        return $this->name;
    }

    protected function getAge() {
        return $this->age;
    }

    private function getColor() {
        return $this->color;
    }
}

$animal = new Animal("Dog", 3, "Brown");
echo "Name: " . $animal->name . "<br>";

?>
