import 'package:carexchange/models/Post.dart';
import 'package:carexchange/models/User.dart';

class Like {
  final int id;
  final Post post;
  final User user;

  Like({
    required this.id,
    required this.post,
    required this.user,
  });

  factory Like.fromJson(Map<String, dynamic> json) {
    return Like(
        id: json['id'],
        user: User.fromJson(json['user']),
        post: Post.fromJson(json['post']));
  }
}
