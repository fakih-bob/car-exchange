import 'dart:convert';

class Picture {
  final int? id;
  final int? postId;
  final String url;

  Picture({
    this.id,
    this.postId,
    required this.url,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'post_id': postId,
      'Url': url, // Matching the JSON field name
    };
  }

  String toJson() => json.encode(toMap());

  factory Picture.fromJson(Map<String, dynamic> json) {
    return Picture(
      id: json['id'],
      postId: json['post_id'],
      url: json['Url'], // Matching the JSON field name
    );
  }
}
