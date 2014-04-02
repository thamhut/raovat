/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : chotam_raovat

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-03-25 22:03:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for raovat_catgory
-- ----------------------------
DROP TABLE IF EXISTS `raovat_catgory`;
CREATE TABLE `raovat_catgory` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name1` varchar(255) NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of raovat_catgory
-- ----------------------------
INSERT INTO `raovat_catgory` VALUES ('0', '1', 'Việc làm', '');
INSERT INTO `raovat_catgory` VALUES ('1', '2', 'Lao động phổ thông', 'vieclamlaodongphothong');
INSERT INTO `raovat_catgory` VALUES ('1', '3', 'Thiết kế - mỹ thuật', 'vieclamthietkemythuat');
INSERT INTO `raovat_catgory` VALUES ('1', '4', 'Quản lý', 'vieclamquanly');
INSERT INTO `raovat_catgory` VALUES ('1', '5', 'Kỹ sư - kiến trúc sư', 'vieclamkisukientrucsu');
INSERT INTO `raovat_catgory` VALUES ('1', '6', 'Công nghệ thông tin', 'vieclamcongnghethongtin');
INSERT INTO `raovat_catgory` VALUES ('1', '7', 'Kế toán - tài chính', 'vieclamketoantaichinh');
INSERT INTO `raovat_catgory` VALUES ('1', '8', 'Kinh doanh - maketing', 'vieclamkinhdoanhmaketing');
INSERT INTO `raovat_catgory` VALUES ('1', '9', 'Dịch vụ', 'vieclamdichvu');
INSERT INTO `raovat_catgory` VALUES ('1', '10', 'Văn phòng - hành chính - nhân sự', 'vieclamvanphonghanhchinhnhansu');
INSERT INTO `raovat_catgory` VALUES ('1', '11', 'Việc làm thêm', 'vieclamvieclamthem');
INSERT INTO `raovat_catgory` VALUES ('1', '12', 'Công việc khác', 'vieclamcongvieckhac');
INSERT INTO `raovat_catgory` VALUES ('0', '13', 'Bất động sản', '');
INSERT INTO `raovat_catgory` VALUES ('13', '14', 'Mua bán nhà - căn hộ', 'batdongsanmuabannhacanho');
INSERT INTO `raovat_catgory` VALUES ('13', '15', 'Mua bán đất', 'batdongsanmuabandat');
INSERT INTO `raovat_catgory` VALUES ('13', '16', 'Văn phòng - nhà xưởng', 'batdongsanvanphongnhaxuong');
INSERT INTO `raovat_catgory` VALUES ('13', '17', 'Thuê nhà đất', 'batdongsanthuenhadat');
INSERT INTO `raovat_catgory` VALUES ('0', '18', 'Điện đại', '');
INSERT INTO `raovat_catgory` VALUES ('18', '19', 'Iphone', 'dienthoaiiphone');
INSERT INTO `raovat_catgory` VALUES ('18', '20', 'Sony', 'dienthoaisony');
INSERT INTO `raovat_catgory` VALUES ('18', '21', 'Nokia', 'dienthoainokia');
INSERT INTO `raovat_catgory` VALUES ('18', '22', 'Samsung', 'dienthoaisamsung');
INSERT INTO `raovat_catgory` VALUES ('18', '23', 'HTC', 'dienthoaihtc');
INSERT INTO `raovat_catgory` VALUES ('18', '24', 'Điện thoại khác', 'dienthoaidienthoaikhac');
INSERT INTO `raovat_catgory` VALUES ('18', '25', 'Linh kiện', '');
INSERT INTO `raovat_catgory` VALUES ('0', '26', 'Mua bán', '');
INSERT INTO `raovat_catgory` VALUES ('26', '27', 'Văn phòng phẩm', 'muabanvanphongpham');
INSERT INTO `raovat_catgory` VALUES ('26', '28', 'Trò chơi - game', 'muabantrochoigame');
INSERT INTO `raovat_catgory` VALUES ('26', '29', 'Cây cảnh - thú nuôi', 'muabancaycanhthunuoi');
INSERT INTO `raovat_catgory` VALUES ('26', '30', 'Thủ công - mỹ nghệ', 'muabanthucongmynghe');
INSERT INTO `raovat_catgory` VALUES ('26', '31', 'Quà tặng', 'muabanquatang');
INSERT INTO `raovat_catgory` VALUES ('26', '32', 'Ẩm thực', 'muabanamthuc');
INSERT INTO `raovat_catgory` VALUES ('26', '33', 'Đồ thể thao - y tế', 'muabandothethaoyte');
INSERT INTO `raovat_catgory` VALUES ('26', '34', 'Sách, truyện, báo,...', 'muabansachtruyen');
INSERT INTO `raovat_catgory` VALUES ('26', '35', 'Nhạc cụ - máy nghe nhạc', 'muabannhaccumaynghenhac');
INSERT INTO `raovat_catgory` VALUES ('26', '36', 'Đồ khác', 'muabandokhac');
INSERT INTO `raovat_catgory` VALUES ('0', '37', 'Điện tử gia dụng', '');
INSERT INTO `raovat_catgory` VALUES ('37', '38', 'Máy ảnh - quay phim', 'dientugiadungmayanhquayphim');
INSERT INTO `raovat_catgory` VALUES ('37', '39', 'Tivi - Tủ lạnh-đầu đĩa', 'dientugiadungtivitulanhdaudia');
INSERT INTO `raovat_catgory` VALUES ('37', '40', 'Máy giặt - ủi', 'dientugiadungmaygiatui');
INSERT INTO `raovat_catgory` VALUES ('37', '41', 'Thiết bị nhà bếp', 'dientugiadungthietbinhabep');
INSERT INTO `raovat_catgory` VALUES ('37', '42', 'Điều hòa-nóng lạnh', 'dientugiadungdieuhoanonglanh');
INSERT INTO `raovat_catgory` VALUES ('37', '43', 'Máy hút bụi', 'dientugiadungmayhutbui');
INSERT INTO `raovat_catgory` VALUES ('37', '44', 'Thiết bị khác', 'dientugiadungthietbikhac');
INSERT INTO `raovat_catgory` VALUES ('0', '45', 'Máy tính', '');
INSERT INTO `raovat_catgory` VALUES ('45', '46', 'Linh kiện', 'maytinhlinhkien');
INSERT INTO `raovat_catgory` VALUES ('45', '47', 'Máy bàn', 'maytinhmayban');
INSERT INTO `raovat_catgory` VALUES ('45', '48', 'Laptop - Notebook, Pad', 'maytinhlaptopnotebookpad');
INSERT INTO `raovat_catgory` VALUES ('45', '49', 'Phần mềm, mạng, web', 'maytinhphanmemmangweb');
INSERT INTO `raovat_catgory` VALUES ('45', '50', 'Màn hình', 'maytinhmanhinh');
INSERT INTO `raovat_catgory` VALUES ('45', '51', 'Máy chiếu, máy in, scan', 'maytinhmaychieumayinscan');
INSERT INTO `raovat_catgory` VALUES ('0', '52', 'Phương tiện đi lại', '');
INSERT INTO `raovat_catgory` VALUES ('52', '53', 'Ô tô', 'phuongtiendilaioto');
INSERT INTO `raovat_catgory` VALUES ('52', '54', 'Xe tải', 'phuongtiendilaixetai');
INSERT INTO `raovat_catgory` VALUES ('52', '55', 'Xe máy', 'phuongtiendilaixemay');
INSERT INTO `raovat_catgory` VALUES ('52', '56', 'Xe đạp', 'phuongtiendilaixedap');
INSERT INTO `raovat_catgory` VALUES ('52', '57', 'Phương tiện khác', 'phuongtiendilaiphuongtienkhac');
INSERT INTO `raovat_catgory` VALUES ('52', '58', 'Linh kiện, sửa chữa', 'phuongtiendilailinhkiensuachua');
INSERT INTO `raovat_catgory` VALUES ('0', '59', 'Thời trang mỹ phẩm', '');
INSERT INTO `raovat_catgory` VALUES ('59', '60', 'Quần áo', 'thoitrangmyphamquanao');
INSERT INTO `raovat_catgory` VALUES ('59', '61', 'Mỹ phẩm – phụ kiện', 'thoitrangmyphammyphamphukien');
INSERT INTO `raovat_catgory` VALUES ('59', '62', 'Thẩm mỹ, làm đẹp', 'thoitrangmyphamthammylamdep');
INSERT INTO `raovat_catgory` VALUES ('59', '63', 'Giày, túi, trang sức,…', 'thoitrangmyphamgiaytuitrangsuc');
INSERT INTO `raovat_catgory` VALUES ('59', '64', 'Thời trang khác', 'thoitrangmyphamkhac');
INSERT INTO `raovat_catgory` VALUES ('0', '65', 'Mẹ và bé', '');
INSERT INTO `raovat_catgory` VALUES ('65', '66', 'Đồ bầu, đồ sơ sinh', 'mevabedobaudososinh');
INSERT INTO `raovat_catgory` VALUES ('65', '67', 'Đồ dùng cho bé', 'mevabedodungchobe');
INSERT INTO `raovat_catgory` VALUES ('65', '68', 'Đồ chơi của bé', 'mevabedochoicuabe');
INSERT INTO `raovat_catgory` VALUES ('65', '69', 'Sữa, Bỉm, đồ dinh dưỡng', 'mevabesuabimdodinhduong');
INSERT INTO `raovat_catgory` VALUES ('65', '70', 'Quần áo trẻ em', 'mevabequanaotreem');
INSERT INTO `raovat_catgory` VALUES ('65', '71', 'Đồ trẻ em khác', '');
INSERT INTO `raovat_catgory` VALUES ('0', '72', 'Sim thẻ', '');
INSERT INTO `raovat_catgory` VALUES ('72', '73', 'Vip, tứ quý, ngũ quý', 'simtheviptuquynguquy');
INSERT INTO `raovat_catgory` VALUES ('72', '74', 'Sim năm sinh', 'simthesimnamsinh');
INSERT INTO `raovat_catgory` VALUES ('72', '75', 'Sim tam hoa', 'simthesimtamhoa');
INSERT INTO `raovat_catgory` VALUES ('72', '76', 'Sim lộc phát, thần tài', 'simthesimlocphatthantai');
INSERT INTO `raovat_catgory` VALUES ('72', '77', 'Sim lặp, kép, taxi', 'simthesimlapkeptaxi');
INSERT INTO `raovat_catgory` VALUES ('72', '78', 'Sim cam kết', 'simthesimcamket');
INSERT INTO `raovat_catgory` VALUES ('72', '79', 'Sim giá rẻ khác', 'simthesimgiarekhac');
INSERT INTO `raovat_catgory` VALUES ('0', '80', 'Dịch vụ', '');
INSERT INTO `raovat_catgory` VALUES ('80', '81', 'Giúp việc nhà', 'dichvugiupviecnha');
INSERT INTO `raovat_catgory` VALUES ('80', '82', 'Thiết kế - kiến trúc- xây dựng', 'dichvuthietkekientrucxaydung');
INSERT INTO `raovat_catgory` VALUES ('80', '83', 'Sửa chữa', 'dichvusuachua');
INSERT INTO `raovat_catgory` VALUES ('80', '84', 'Thuê và cho thuê', 'dichvuthuevachothue');
INSERT INTO `raovat_catgory` VALUES ('80', '85', 'Dịch vụ tư vấn', 'dichvudichvutuvan');
INSERT INTO `raovat_catgory` VALUES ('80', '86', 'Tuyển sinh - Đào tạo', 'dichvutuyensinhdaotao');
INSERT INTO `raovat_catgory` VALUES ('80', '87', 'Bảo vệ, Vệ sỹ, Thám tử', 'dichvubaovevesythamtu');
INSERT INTO `raovat_catgory` VALUES ('80', '88', 'In Ấn - Quảng cáo', 'dichvuinanquangcao');
INSERT INTO `raovat_catgory` VALUES ('80', '89', 'PR / Tổ chức sự kiện', 'dichvuprtochucsukien');
INSERT INTO `raovat_catgory` VALUES ('80', '90', 'Giữ trẻ', 'dichvugiutre');
INSERT INTO `raovat_catgory` VALUES ('80', '91', 'Vệ sinh, thông, tắc', 'dichvuvesinhthongtac');
INSERT INTO `raovat_catgory` VALUES ('80', '92', 'Sức khỏe - Thể hình', 'dichvusuckhoethehinh');
INSERT INTO `raovat_catgory` VALUES ('80', '93', 'Du lịch', 'dichvudulich');
INSERT INTO `raovat_catgory` VALUES ('80', '94', 'Vận tải, chuyển phát, lưu kho', 'dichvuvantaichuyenphatluukho');
INSERT INTO `raovat_catgory` VALUES ('80', '95', 'Viết lách - Biên tập - Dịch thuật', 'dichvuvietlachbientapdichthuat');
INSERT INTO `raovat_catgory` VALUES ('80', '96', 'Đóng vai - trình diễn thử', 'dichvudongvaitrinhdienthu');
INSERT INTO `raovat_catgory` VALUES ('80', '97', 'Dịch vụ khác', 'dichvudichvukhac');
