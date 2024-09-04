import 'dart:convert';

class RegistrationUser {
  final String email;
  final String password;

  RegistrationUser({
    required this.email,
    required this.password,
  });

  Map<String, dynamic> toMap() {
    return {
      'email': email,
      'password': password,
    };
  }

  String toJson() => json.encode(toMap());
}
