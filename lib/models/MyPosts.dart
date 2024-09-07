import 'package:carexchange/models/Address.dart';
import 'package:carexchange/models/Car.dart';
import 'package:carexchange/models/Post.dart';
import 'package:carexchange/models/User.dart';

class MyPost {
  final int MyPostId;
  final Car car;

  MyPost({
    required this.MyPostId,
    required this.car,
  });

  factory MyPost.fromJson(Map<String, dynamic> json) {
    return MyPost(
      MyPostId: json['MyPostId'],
      car: Car.fromJson(json['car']),
    );
  }
}
