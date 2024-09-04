import 'package:carexchange/models/Address.dart';
import 'package:carexchange/models/Car.dart';
import 'package:carexchange/models/Post.dart';
import 'package:carexchange/models/User.dart';

class MyPost {
  final int postId;
  final Car car;

  MyPost({
    required this.postId,
    required this.car,
  });

  factory MyPost.fromJson(Map<String, dynamic> json) {
    return MyPost(
      postId: json['id'],
      car: Car.fromJson(json['car']),
    );
  }
}
