class Category {
  final String title;
  final String image;

  Category({required this.image, required this.title});
}

final List<Category> categories = [
  Category(image: 'assets/images/car-icon.jpg', title: 'Car'),
  Category(image: 'assets/images/motorcycle-icon.jpg', title: 'MotorCycle'),
  Category(image: 'assets/images/Truck-icon.jpg', title: 'Truck'),
];
