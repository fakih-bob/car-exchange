import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

class DioClient1 {
  final Dio _dio;
  final SharedPreferences _prefs;

  DioClient1._internal(this._prefs)
      : _dio = Dio(BaseOptions(
          baseUrl: 'http://10.0.2.2:8000/api',
          connectTimeout: const Duration(seconds: 14),
          receiveTimeout: const Duration(seconds: 14),
          contentType: Headers.jsonContentType,
          responseType: ResponseType.json,
          validateStatus: (status) => status! < 500,
        )) {
    _setAuthorizationToken();

    _dio.interceptors.add(
      InterceptorsWrapper(
        onRequest: (options, handler) {
          final token = _prefs.getString('token');
          if (token != null) {
            options.headers['Authorization'] = 'Bearer $token';
          }
          return handler.next(options); // Continue with the request
        },
      ),
    );
  }

  static DioClient1? _singleton;

  factory DioClient1(SharedPreferences prefs) {
    _singleton ??= DioClient1._internal(prefs);
    return _singleton!;
  }

  Dio getInstance() {
    return _dio;
  }

  void _setAuthorizationToken() {
    final token = _prefs.getString('token');
    if (token != null) {
      _dio.options.headers['Authorization'] = 'Bearer $token';
    }
  }

  void setAuthorizationToken(String token) {
    _prefs.setString('token', token); // Optionally update SharedPreferences
    _dio.options.headers['Authorization'] = 'Bearer $token';
  }
}
