import 'dart:convert';

class Car {
  final int id;
  final String category;
  final String brand;
  final String name;
  final String color;
  final String description;
  final double miles;
  final int year;
  final String url;
  final double? price; // Fixed field name to match JSON

  Car(
      {required this.id,
      required this.category,
      required this.brand,
      required this.name,
      required this.color,
      required this.description,
      required this.miles,
      required this.year,
      required this.url,
      this.price});

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
      'Url': url,
      'price': price
    };
  }

  String toJson() => json.encode(toMap());

  factory Car.fromJson(Map<String, dynamic> json) {
    return Car(
        id: json['id'],
        category: json['category'],
        brand: json['brand'],
        name: json['name'],
        color: json['color'],
        description: json['description'],
        miles:
            (json['miles'] as num).toDouble(), // Handle numeric type conversion
        year: json['year'],
        url: json['Url'],
        price:
            (json['price'] as num?)?.toDouble() // Matching the JSON field name
        );
  }
}
