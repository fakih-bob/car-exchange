import 'dart:convert';
import 'Car.dart';
import 'Address.dart';
import 'Picture.dart';

class UpdatingPost {
  final int id;
  final Car car;
  final Address address;
  final List<Picture> pictures;

  UpdatingPost({
    required this.id,
    required this.car,
    required this.address,
    required this.pictures,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'car': car.toMap(),
      'address': address.toMap(),
      'pictures': pictures.map((pic) => pic.toMap()).toList(),
    };
  }

  String toJson() => json.encode(toMap());

  factory UpdatingPost.fromJson(Map<String, dynamic> json) {
    return UpdatingPost(
      id: json['id'],
      car: Car.fromJson(json['car']),
      address: Address.fromJson(json['address']),
      pictures: (json['pictures'] as List<dynamic>)
          .map((item) => Picture.fromJson(item as Map<String, dynamic>))
          .toList(),
    );
  }
}
