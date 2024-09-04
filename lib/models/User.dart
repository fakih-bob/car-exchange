import 'dart:convert';

class User {
  final int? id;
  final String? name;
  final String email;
  final String? phoneNumber;
  final String? password;

  User({
    this.id,
    this.name,
    required this.email,
    this.phoneNumber,
    this.password,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'phoneNumber': phoneNumber,
      'password': password,
    };
  }

  String toJson() => json.encode(toMap());

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'] as int,
      name: json['name'] as String?,
      email: json['email'] as String, // Required field
      phoneNumber: json['phoneNumber'] as String?,
      password: json['password'] as String?, // Required field
    );
  }
}
