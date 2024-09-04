import 'dart:convert';

class Address {
  final int? id;
  final String country;
  final String street;
  final String city;
  final String description;

  Address({
    this.id,
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
      country: json['country'] ?? 'Unknown country',
      street: json['street'] ?? 'Unknown street',
      city: json['city'] ?? 'Unknown city',
      description: json['description'] ?? 'No description',
    );
  }
}
