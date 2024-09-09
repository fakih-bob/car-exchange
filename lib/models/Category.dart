class Category {
  final String title;
  final String image;

  Category({required this.image, required this.title});
}

final List<Category> categories = [
  Category(image: 'assets/images/logo.png', title: 'Car'),
  Category(image: 'assets/images/Header.jpg', title: 'MotorCycle'),
  Category(image: 'assets/images/logo.png', title: 'Truck'),
];
