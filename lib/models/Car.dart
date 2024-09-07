import 'dart:convert';

class Car {
  final int? id;
  final String category;
  final String brand;
  final String name;
  final String color;
  final String description;
  final double miles;
  final int year;
  final String Url;
  final double? price; // Nullable price

  Car({
    this.id,
    required this.category,
    required this.brand,
    required this.name,
    required this.color,
    required this.description,
    required this.miles,
    required this.year,
    required this.Url,
    this.price,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'category': category,
      'brand': brand,
      'name': name,
      'color': color,
      'description': description,
      'miles': miles,
      'year': year,
      'Url': Url,
      'price': price
    };
  }

  String toJson() => json.encode(toMap());

  factory Car.fromJson(Map<String, dynamic> json) {
    return Car(
      id: json['id'],
      category: json['category'] ?? 'Unknown category',
      brand: json['brand'] ?? 'Unknown brand',
      name: json['name'] ?? 'No name',
      color: json['color'] ?? 'Unknown color',
      description: json['description'] ?? 'No description',
      miles: (json['miles'] as num?)?.toDouble() ?? 0.0,
      year: json['year'] ?? 0,
      Url: json['Url'],
      price: (json['price'] as num?)?.toDouble(),
    );
  }

  get pictures => null;
}
