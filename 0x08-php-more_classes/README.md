# 0x08 - PHP More Classes

This repository contains a series of educational PHP scripts that progressively introduce and demonstrate **Object-Oriented Programming (OOP)** concepts using PHP. Each file builds upon the previous one, offering hands-on experience with classes, objects, inheritance, method overriding, and more.

The series starts with a basic `Rectangle` class and evolves it through getter/setter methods, string representation, display logic, rotation, and scaling. It then introduces the `Square` class as a specialized version of `Rectangle`, showcasing inheritance and polymorphism. The final challenge includes solving the classic **N-Queens** problem using backtracking — applying OOP to real-world algorithmic design.

---

## Table of Contents

1. [Files Overview](#files-overview)
2. [Learning Objectives](#learning-objectives)
3. [How to Use](#how-to-use)
4. [Example Output](#example-output)
5. [License](#license)

---

## Files Overview

| File | Description |
|------|-------------|
| `0-rectangle.php` | Basic Rectangle class with area method |
| `1-rectangle.php` | Adds validation and getter/setter methods |
| `2-rectangle.php` | Implements `__toString()` for string representation |
| `3-rectangle.php` | Adds a `display()` method to print rectangle visually |
| `4-rectangle.php` | Adds `rotate()` and `double()` methods |
| `5-square.php` | Introduces Square class extending Rectangle |
| `6-square.php` | Adds size getter/setter in Square class |
| `7-square.php` | Customizes display character for Square |
| `8-square.php` | Adds position handling to Square |
| `9-square.php` | Implements comparison between Squares |
| `101-n_queens.php` | Solves N-Queens problem using backtracking and OOP |

---

## Learning Objectives

By completing this series, you will learn:

- How to define and use classes and objects in PHP
- Encapsulation using private/protected properties
- Getter and setter methods for controlled access
- Inheritance and subclassing (`extends`)
- Method overriding
- Magic methods like `__toString()`
- Implementing custom logic such as rotation, scaling, and comparison
- Using OOP principles to solve complex problems like N-Queens

---

##  How to Use

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/0x08-php-more_classes.git 
   ```

2. Navigate to the directory:
   ```bash
   cd 0x08-php-more_classes
   ```

3. Run individual PHP files via CLI:
   ```bash
   php 0-rectangle.php
   ```

4. Or serve via web server (e.g., Apache or built-in PHP server):
   ```bash
   php -S localhost:8000
   ```

---

## 🔍 Example Output

### Example from `3-rectangle.php`:
```php
$rect = new Rectangle(5, 3);
$rect->display();
// Output:
// *****
// *****
// *****
```

### Example from `101-n_queens.php`:
```text
Solution 1:
.Q..
...Q
Q...
..Q.

Solution 2:
..Q.
Q...
...Q
.Q..
```

---

## License

MIT License

Copyright (c) 2025 Alpha Omollo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
