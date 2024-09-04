import 'package:dio/dio.dart';

class DioClient {
  Dio getInstance() {
    return Dio(
      BaseOptions(
          baseUrl: 'http://10.0.2.2:8000/api',
          connectTimeout: Duration(seconds: 14),
          receiveTimeout: Duration(seconds: 14),
          contentType: Headers.jsonContentType,
          responseType: ResponseType.json,
          validateStatus: (status) {
            return status! < 500;
          }),
    );
  }

  static post(String s, {required Map<String, String> data}) {}
}
