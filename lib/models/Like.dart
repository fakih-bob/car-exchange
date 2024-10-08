import 'package:carexchange/models/Address.dart';
import 'package:carexchange/models/Car.dart';
import 'package:carexchange/models/Post.dart';
import 'package:carexchange/models/User.dart';

class Like {
  final int postId;
  final Car car;
  final Address address;

  Like({
    required this.postId,
    required this.car,
    required this.address,
  });

  factory Like.fromJson(Map<String, dynamic> json) {
    return Like(
      postId: json['post_id'],
      car: Car.fromJson(json['car']),
      address: Address.fromJson(json['address']),
    );
  }
}
