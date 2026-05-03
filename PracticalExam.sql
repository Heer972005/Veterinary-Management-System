use sem4;

create table flight(
flightID int,
origin varchar(50),
destination varchar(50),
planeID int
);
create table passenger(
passID int,
name varchar(50),
age int,
passNumber varchar(50)
);
create table aircraft(
planeID int,
model varchar(50),
capacity int
);
create table booking(
bookingID int,
flightID INT,
passID int,
seatNo varchar(50),
fare int
);

insert into flight() 
values(1,'Mumbai','Delhi',10);
insert into flight()
values(2,'Rajkot','Mumbai',20);
insert into flight()
values(3,'LA','Newyork',30);
insert into flight()
values(4,'Delhi','Abu-Dhabi',10);
INSERT INTO flight()
values(5,'Kolkata','Cochi',20);


insert into passenger()
values(1,'Nand',25,'Pass001');
insert into passenger()
values(2,'Aman',36,'Pass002');
insert into passenger()
values(3,'Smit',23,'Pass003');
insert into passenger()
values(4,'Prarthana',22,'Pass004');
insert into passenger()
values(5,'Krisha',25,'Pass005');


insert into aircraft()
values(10,'M001',100);
insert into aircraft()
values(60,'M002',200);
insert into aircraft()
values(20,'M003',100);
insert into aircraft()
values(30,'M004',200);
insert into aircraft()
values(40,'M005',100);


insert into booking()
values(1, 1, 1, 'A1', 5000);
insert into booking()
values(2, 1, 2, 'A2', 5000);
insert into booking()
values(3, 2, 1, 'B1', 6000);
insert into booking()
values(4, 3, 3, 'C1', 7000);
insert into booking()
values(5, 1, 1, 'A3', 5000);

select * from flight;
select * from booking;
select * from aircraft;
select * from passenger;

delimiter &&
create procedure Get_Flight_Revenue(
in flightID int
)
begin
 select count(*) as totalTickets, sum(fare) from booking where flightID=flightID;
 end &&
DELIMITER ;
call Get_Flight_Revenue(1);


select pn.name, f.destination
from passenger pn
join booking b on pn.PassID = b.passID
join flight f ON b.flightID = f.flightID
GROUP BY pn.passID, f.planeID
HAVING COUNT(b.flightID) > 3;

