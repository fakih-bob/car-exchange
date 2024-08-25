import 'dart:convert';
import 'Car.dart';
import 'Address.dart';
import 'User.dart';
import 'Picture.dart';

class Post {
  final int id;
  final Car car;
  final Address address;
  final User userInfo;
  final List<Picture> pictures;

  Post({
    required this.id,
    required this.car,
    required this.address,
    required this.userInfo,
    required this.pictures,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'car': car.toMap(),
      'address': address.toMap(),
      'user': userInfo.toMap(),
      'pictures': pictures.map((pic) => pic.toMap()).toList(),
    };
  }

  String toJson() => json.encode(toMap());

  factory Post.fromJson(Map<String, dynamic> json) {
    return Post(
      id: json['id'],
      car: Car.fromJson(json['car']),
      address: Address.fromJson(json['address']),
      userInfo: User.fromJson(json['user']),
      pictures: (json['pictures'] as List<dynamic>)
          .map((item) => Picture.fromJson(item as Map<String, dynamic>))
          .toList(),
    );
  }
}
