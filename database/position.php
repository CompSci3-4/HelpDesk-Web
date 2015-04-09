<?php
abstract class Position {
    const User = 1;
    const Consultant = 2;
    const Manager = 3;
    const Admin = 4;

    public static function toString($id) {
        $strings = [Position::User => "User",
                    Position::Consultant => "Consultant",
                    Position::Manager => "Manager",
                    Position::Admin => "Admin"];
        return $strings[$id];
    }
}
?>
