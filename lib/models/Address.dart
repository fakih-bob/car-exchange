import 'dart:convert';

class Address {
  final int id;
  final String country;
  final String street;
  final String city;
  final String description;

  Address({
    required this.id,
    required this.country,
    required this.street,
    required this.city,
    required this.description,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'country': country,
      'street': street,
      'city': city,
      'description': description,
    };
  }

  String toJson() => json.encode(toMap());

  factory Address.fromJson(Map<String, dynamic> json) {
    return Address(
      id: json['id'],
      country: json['country'],
      street: json['street'],
      city: json['city'],
      description: json['description'],
    );
  }
}
