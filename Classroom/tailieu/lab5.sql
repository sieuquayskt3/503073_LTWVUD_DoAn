create database QLTT
use QLTT
--Cau 1
create table Sinhvien (
masv char (10) primary key,
ten nvarchar(50),
quequan nvarchar(50),
ngaysinh date,
HL real check (HL >=0 and HL<=10))

create table Detai (
madt char(10) primary key,
tendt nvarchar(50),
cndt nvarchar(50),
KP int check (KP < 100000000))

alter table detai add constraint df_KP_Detai  default (0) for KP 

create table Sinhvien_Detai (
masv char(10),
madt char(10),
Noitt nvarchar(50),
quangduong int,
KQ int,
primary key (masv,madt))
alter table Sinhvien_Detai add constraint fk_Sinhvien_Detai_masv_Sinhvien foreign key (masv) references Sinhvien (masv)
alter table Sinhvien_Detai add constraint fk_Sinhvien_Detai_madt_Detai foreign key (madt) references Detai (madt)

alter table Sinhvien_Detai drop constraint fk_Sinhvien_Detai_masv_Sinhvien

insert into Sinhvien values('51800825',N'Nguyễn Thị Huyền Trang',N'Gia Lai','6/20/2000','8.5'),
							('51800775',N'Trần Thu Hồng',N'Vũng Tàu','10/9/1990','8'),
							('51800157',N'Phạm Văn Vĩ',N'Hải Phòng ','1/1/1979','7.5'),
							('51800667',N'Huỳnh Thị Thu Uyên',N'Cần Thơ','11/20/2000','8.1'),
							('51881908',N'Cao Minh Phương',N'Vũng Tàu','4/17/1992','6'),
							('51800159',N'Lê Văn Lâm',N'Tp HCM','4/12/2000','7.5'),
							('51800467',N'Trần Nữ Huyền Trân',N'Hà Nội','2/20/2002','8.9'),
							('51881909',N'Hứa Minh Đạt',N'Hải Phòng','8/17/1992','9')

insert into Detai values('1',N'Hệ điều hành',N'Trần Trung Tín','2000000'),
						('2',N'Hệ cơ sở dữ liệu',N'Trần Thị Hồng Nhung','3000000'),
						('3',N'Cấu trúc rời rạc',N'Nguyễn Thị Hiền','900000'),
						('4',N'Giải tích',N'Lê Thị Giang','800000'),
						('5',N'Đại số',N'Trần Văn Hùng','5000000'),
						('6',N'Lập trình C',N'Phùng Quốc Đạt','1000000')

insert Sinhvien_Detai values('51800825','1',N'Gia Lai','600','8'),
							('51800775','2',N'Tp HCM','200','7'),
							('51800157','3',N'Cần Thơ','300','7'),
							('51800667','2',N'Cần Thơ','300','8'),
							('51881908','5',N'Hải Phòng','800','9'),
							('51800159','3',N'Gia Lai','600','6'),
							('51800467','5',N'Hà Nội','700','7'),
							('51881909','1',N'Vũng Tàu','400','9')

select * from Sinhvien_Detai

--Cau2
--a
create view SvHl AS
Select * from Sinhvien where year(getdate()) - year(ngaysinh) < 20 and HL > 8.5
select * from SvHl

--b
create view Thongtin AS
select * from Detai where  KP > 1000000
select * from Thongtin

--c
create view Danhsach AS
select ten from Sinhvien,Sinhvien_Detai where Sinhvien.masv = Sinhvien_Detai.masv and year(getdate())- year(ngaysinh) < 20 and HL > 8 and KQ > 8
select * from Danhsach

--d
create view CNDT AS
select cndt from Sinhvien, Detai ,Sinhvien_Detai where Sinhvien.masv= Sinhvien_Detai.masv
 and Detai.madt = Sinhvien_Detai.madt and Sinhvien.quequan like 'Tp HCM'
select * from CNDT
--e
create view HP AS
select * from Sinhvien where year(ngaysinh) < 1980 and quequan like N'Hải Phòng'
select * from HP

--f
create view DTB AS
select quequan,avg(HL) as diemtb from Sinhvien where quequan like N'Hà Nội' group by (quequan)
select * from DTB

--g
create view Sotinh AS
select count(noitt) as sotinh from Sinhvien_Detai where madt = 5
select * from Sotinh

--h
create view Nhom AS
select quequan, count(quequan) as sosv from Sinhvien,Sinhvien_Detai where Sinhvien.masv = Sinhvien_Detai.masv 
and madt = 5 group by (quequan)
select * from Nhom

--Cau3
--a
select tendt, count(masv) as soluong from Sinhvien_Detai,Detai where Sinhvien_Detai.madt = Detai.madt  
group by (tendt) having count(masv) >= 2

--b
select * from sinhvien  where HL > all (
select HL from Sinhvien where quequan like 'Tp HCM')

--c

--d
select * from Sinhvien, Sinhvien_Detai where Sinhvien_Detai.masv = Sinhvien.masv and quequan like noitt

--e
select tendt as monhockhongcosv from Detai except 
select tendt from Detai, Sinhvien_Detai where Detai.madt = Sinhvien_Detai.madt 

--f
select tendt from Sinhvien_Detai, Detai where Detai.madt = Sinhvien_Detai.madt and masv in(
select masv from Sinhvien where HL in (
select max(HL) as diemcaonhatlop from Sinhvien,Sinhvien_Detai
    where Sinhvien.masv = Sinhvien_Detai.masv))

--g
select tendt from Sinhvien_Detai, Detai where Detai.madt = Sinhvien_Detai.madt and masv not in( 
select masv from Sinhvien where HL in (
select min(HL) as Diemkemnhat from Sinhvien,Sinhvien_Detai
    where Sinhvien.masv = Sinhvien_Detai.masv))

--h
select ten, KP from Sinhvien,Detai,Sinhvien_Detai where Sinhvien.masv = Sinhvien_Detai.masv and 
Detai.madt = Sinhvien_Detai.madt and Detai.KP > (
select sum(KP)/5 as Tongkinhphi from Detai )
--i
select ten, HL from Sinhvien where HL > (
select madt,avg(KQ) as diemthuctaptb from Sinhvien_Detai where madt like 1 group by (madt))
