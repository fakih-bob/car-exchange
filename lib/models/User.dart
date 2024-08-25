import 'dart:convert';

class User {
  final int id;
  final String name;
  final String email;
  final String phoneNumber;

  User({
    required this.id,
    required this.name,
    required this.email,
    required this.phoneNumber,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'phoneNumber': phoneNumber,
    };
  }

  String toJson() => json.encode(toMap());

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      phoneNumber: json['phoneNumber'],
    );
  }
}
